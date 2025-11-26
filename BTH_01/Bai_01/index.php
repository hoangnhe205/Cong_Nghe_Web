<?php
include 'data.php';
// helper: shorten description for excerpt
function excerpt($text, $len = 140) {
    if (mb_strlen($text) <= $len) return $text;
    $s = mb_substr($text, 0, $len);
    // cut back to last space
    $s = preg_replace('/\s+[^\s]*$/u', '', $s);
    return $s . '...';
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Danh sách các loài hoa - Trang khách</title>
    <style>
        :root{--card-bg:#fff;--muted:#6b6b6b}
        body{font-family: 'Segoe UI', Tahoma, Arial, sans-serif;background:#f3f6fb;margin:0;padding:24px}
        .site{max-width:1100px;margin:0 auto}
        header{margin-bottom:20px}
        h1{font-size:1.6rem;margin:0 0 6px}
        .lead{color:var(--muted);margin:0 0 18px}

        .grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:18px}
        article.card{background:var(--card-bg);border-radius:10px;box-shadow:0 6px 18px rgba(20,30,50,0.06);overflow:hidden;display:flex;flex-direction:column}
        .thumb{width:100%;height:180px;overflow:hidden}
        .thumb img{width:100%;height:100%;object-fit:cover;display:block}
        .card-body{padding:14px;flex:1;display:flex;flex-direction:column}
        .meta{font-size:0.85rem;color:var(--muted);margin-bottom:8px}
        .title{margin:0 0 8px;font-size:1.05rem}
        .excerpt{color:#333;flex:1}
        .actions{margin-top:12px;display:flex;gap:8px;align-items:center}
        .btn{display:inline-block;padding:8px 12px;border-radius:8px;text-decoration:none;border:0;cursor:pointer}
        .btn-primary{background:#2f80ed;color:#fff}
        .btn-outline{background:transparent;border:1px solid #ddd;color:#333}

        /* full description (hidden by default) */
        .full-desc{display:none;margin-top:10px;color:#222}

        @media (max-width:480px){.thumb{height:140px}}
    </style>
    <script>
        function toggleDesc(id, btn){
            const el = document.getElementById(id);
            if (!el) return;
            const shown = el.style.display === 'block';
            el.style.display = shown ? 'none' : 'block';
            if(btn) btn.textContent = shown ? 'Đọc tiếp' : 'Thu gọn';
        }
    </script>
</head>
<body>
    <div class="site">
        <header>
            <a href="admin.php" style="float:right;text-decoration:none;margin-top:6px;" class="btn btn-outline">🔑 Quản trị</a>
            <h1>🌷 Bài viết mẫu — Các loài hoa</h1>
            <p class="lead">Trang dành cho khách: xem các bài viết mẫu lấy dữ liệu từ <code>data.php</code>.</p>
        </header>

        <section class="grid">
            <?php foreach ($flowers as $i => $fl): 
                // sample meta data
                $pubDate = date('d/m/Y', strtotime('-'.($i%30).' days'));
                $author = 'Khách';
                $short = excerpt($fl['desc'], 130);
                $id = 'desc-' . $i;
            ?>
            <article class="card">
                <div class="thumb">
                    <img src="<?= htmlspecialchars($fl['img']) ?>" alt="<?= htmlspecialchars($fl['name']) ?>">
                </div>
                <div class="card-body">
                    <div class="meta"><?= $pubDate ?> • <?= $author ?></div>
                    <h2 class="title"><?= htmlspecialchars($fl['name']) ?></h2>
                    <div class="excerpt"><?= htmlspecialchars($short) ?></div>
                    <div id="<?= $id ?>" class="full-desc"><?= htmlspecialchars($fl['desc']) ?></div>
                    <div class="actions">
                        <button class="btn btn-primary" onclick="toggleDesc('<?= $id ?>', this)">Đọc tiếp</button>
                        <a class="btn btn-outline" href="#">Xem danh mục</a>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </section>
    </div>
</body>
</html>