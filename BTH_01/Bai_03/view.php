<?php
// Simple safe viewer: prefer CSV parsing; if file is XLSX and ZipArchive is missing,
// show a clear instruction instead of attempting unreliable extraction.
header('Content-Type: text/html; charset=utf-8');

$dir = __DIR__;
$default = $dir . DIRECTORY_SEPARATOR . '65HTTT_Danh_sach_diem_danh.csv';
$file = $default;
if (!file_exists($file)) {
    foreach (scandir($dir) as $f) {
        if (preg_match('/65.*danh.*(csv|xlsx|xls)/i', $f)) { $file = $dir . DIRECTORY_SEPARATOR . $f; break; }
    }
}

if (!file_exists($file)) {
    $error = 'Không tìm thấy tệp danh sách trong thư mục.';
    $rows = [];
} else {
    // Read first bytes to detect PK (xlsx)
    $fh = fopen($file, 'rb');
    $first = fread($fh, 4);
    fclose($fh);

    if ($first === "PK\x03\x04") {
        // XLSX detected
        if (class_exists('ZipArchive')) {
            // reuse the earlier parsing logic (ZipArchive)
            $zip = new ZipArchive;
            if ($zip->open($file) === true) {
                $shared = [];
                if (($idx = $zip->locateName('xl/sharedStrings.xml')) !== false) {
                    $xml = $zip->getFromIndex($idx);
                    $sxml = @simplexml_load_string($xml);
                    if ($sxml !== false) foreach ($sxml->si as $si) {
                        if (isset($si->t)) $shared[] = (string)$si->t;
                        else { $str=''; foreach ($si->r as $r) $str .= (string)$r->t; $shared[] = $str; }
                    }
                }
                $sheetIndex = $zip->locateName('xl/worksheets/sheet1.xml');
                if ($sheetIndex === false) {
                    $sheetIndex = -1; for ($i=0;$i<$zip->numFiles;$i++) { $name = $zip->getNameIndex($i); if (preg_match('#^xl/worksheets/sheet\d+\.xml$#',$name)) { $sheetIndex = $i; break; } }
                }
                if ($sheetIndex !== -1) {
                    $xml = $zip->getFromIndex($sheetIndex);
                    $sxml = @simplexml_load_string($xml);
                    $rows = [];
                    if ($sxml !== false) {
                        foreach ($sxml->sheetData->row as $r) {
                            $cells = [];
                            foreach ($r->c as $c) {
                                $ref = (string)$c['r'];
                                $col = preg_replace('/\d+/','',$ref);
                                // convert column to index (A->0, B->1...)
                                $idx = 0; $len = strlen($col);
                                for ($i=0;$i<$len;$i++) $idx = $idx*26 + (ord($col[$i]) - 64);
                                $idx = $idx-1;
                                $val = '';
                                if ((string)$c['t'] === 's') { $v = (string)$c->v; $val = isset($shared[(int)$v]) ? $shared[(int)$v] : ''; }
                                else { if (isset($c->v)) $val = (string)$c->v; elseif (isset($c->is->t)) $val = (string)$c->is->t; }
                                $cells[$idx] = $val;
                            }
                            ksort($cells); $rows[] = array_values($cells);
                        }
                    }
                } else { $error = 'Không tìm thấy worksheet trong XLSX.'; }
                $zip->close();
            } else { $error = 'Không thể mở file XLSX bằng ZipArchive.'; }
        } else {
            // Avoid trying PowerShell automatically; show instructions instead
            $error = 'Tệp là XLSX/Office Open XML nhưng PHP extension "zip" (ZipArchive) không được bật.\n' .
                     'Hãy bật extension này trong php.ini (ví dụ: C:\\xampp\\php\\php.ini) bằng cách bỏ dấu `;` trước `extension=zip`, sau đó khởi động lại Apache.\n' .
                     'Hoặc mở file bằng Excel và lưu lại dưới dạng CSV (File → Save As → CSV) rồi tải lên.';
            $rows = [];
        }
    } else {
        // treat as CSV
        $rows = [];
        if (($h = fopen($file,'r')) !== false) {
            // remove BOM from first cell if present
            $firstLine = fgets($h);
            if ($firstLine !== false && strpos($firstLine, "\xEF\xBB\xBF") === 0) $firstLine = substr($firstLine,3);
            // rewind and use fgetcsv for reliable parsing
            rewind($h);
            while (($r = fgetcsv($h)) !== false) $rows[] = $r;
            fclose($h);
        } else { $error = 'Không thể mở file CSV.'; }
    }
}

// Render
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Hiển thị danh sách sinh viên</title>
    <style>
        body{font-family:Segoe UI,Arial,Helvetica,sans-serif;background:#f4f6fb;margin:20px}
        .wrap{max-width:1200px;margin:0 auto;background:#fff;padding:18px;border-radius:8px;box-shadow:0 6px 18px rgba(20,30,60,0.06)}
        h1{margin:0 0 8px}
        table{width:100%;border-collapse:collapse;font-size:13px}
        th,td{border:1px solid #e6e9ef;padding:8px;text-align:left}
        th{background:#f6f8fc}
        .muted{color:#666;font-size:0.95rem}
        .error{background:#fdecea;color:#611a15;padding:12px;border-radius:6px;margin-top:12px}
    </style>
</head>
<body>
    <div class="wrap">
        <h1>Danh sách sinh viên — 65HTTT</h1>
        <div class="muted">Tệp: <?= htmlspecialchars(basename($file)) ?></div>

        <?php if (isset($error)): ?>
            <div class="error">Lỗi: <?= nl2br(htmlspecialchars($error)) ?></div>
        <?php elseif (empty($rows)): ?>
            <div style="margin-top:12px;">Không có dữ liệu để hiển thị.</div>
        <?php else: ?>
            <div style="overflow:auto;margin-top:12px">
            <table>
                <thead>
                    <tr>
                        <?php
                        // if first row looks like header, use it
                        $first = $rows[0];
                        $useHeader = false;
                        if (!empty($first)) {
                            $lower = array_map('strtolower',$first);
                            foreach ($lower as $v) if (strpos($v,'mã')!==false || strpos($v,'tên')!==false || strpos($v,'user')!==false) { $useHeader = true; break; }
                        }
                        $header = $useHeader ? $first : ['Mã SV','Mật khẩu','Họ','Tên','Lớp','Email','Môn học'];
                        if ($useHeader) array_shift($rows);
                        ?>
                        <th>STT</th>
                        <?php foreach ($header as $h): ?><th><?= htmlspecialchars($h) ?></th><?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($rows as $i => $r): ?>
                    <tr>
                        <td style="font-weight:bold"><?= $i+1 ?></td>
                        <?php for ($c=0;$c<count($header);$c++): ?><td><?= htmlspecialchars(isset($r[$c])?$r[$c]:'') ?></td><?php endfor; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>