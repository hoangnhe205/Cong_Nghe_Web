<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài Thi Trắc Nghiệm Android</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2.2em;
            margin-bottom: 10px;
        }
        
        .header .subtitle {
            font-size: 1.1em;
            opacity: 0.9;
        }
        
        .exam-info {
            background: #f8f9fa;
            padding: 15px 30px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .stats {
            background: #e8f4fd;
            padding: 15px 30px;
            border-bottom: 1px solid #b8daff;
            text-align: center;
        }
        
        .question-container {
            padding: 30px;
            max-height: 70vh;
            overflow-y: auto;
        }
        
        .question {
            background: #f8f9fa;
            border-left: 4px solid #3498db;
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 0 8px 8px 0;
            transition: all 0.3s ease;
        }
        
        .question:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .question-number {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 1.1em;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .question-type {
            background: #3498db;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.8em;
        }
        
        .question-text {
            font-size: 1.1em;
            margin-bottom: 15px;
            color: #2c3e50;
            line-height: 1.5;
        }
        
        .options {
            list-style: none;
            margin: 15px 0;
        }
        
        .option {
            padding: 12px 15px;
            margin: 8px 0;
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .option.correct {
            border-color: #2ecc71;
            background: #d5f4e6;
        }
        
        .option.incorrect {
            border-color: #e74c3c;
            background: #fadbd8;
        }
        
        .answer-marker {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-weight: bold;
        }
        
        .correct .answer-marker {
            color: #27ae60;
        }
        
        .incorrect .answer-marker {
            color: #c0392b;
        }
        
        .multiple-answer {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
        }
        
        .controls {
            padding: 20px 30px;
            background: #f8f9fa;
            border-top: 1px solid #e9ecef;
            text-align: center;
        }
        
        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1em;
            font-weight: bold;
            transition: all 0.3s ease;
            margin: 0 5px;
        }
        
        .btn-toggle {
            background: #3498db;
            color: white;
        }
        
        .btn-toggle:hover {
            background: #2980b9;
        }
        
        .btn-reset {
            background: #e74c3c;
            color: white;
        }
        
        .btn-reset:hover {
            background: #c0392b;
        }
        
        .answer-hidden .correct,
        .answer-hidden .incorrect,
        .answer-hidden .answer-marker {
            display: none;
        }
        
        .answer-hidden .option {
            border-color: #e9ecef;
            background: white;
        }
        
        .scroll-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #3498db;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            font-size: 1.2em;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
        }
        
        .scroll-top:hover {
            background: #2980b9;
            transform: translateY(-3px);
        }
        
        @media (max-width: 768px) {
            .exam-info {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
            
            .question-container {
                padding: 15px;
            }
            
            .header h1 {
                font-size: 1.8em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>BÀI THI TRẮC NGHIỆM ANDROID</h1>
            <div class="subtitle">Đọc từ file Quiz.txt</div>
        </div>
        <div class="exam-info">
            <div class="info-item">
                <strong>Tổng số câu:</strong> <span id="total-questions">0</span>
            </div>
            <div class="info-item">
                <strong>Thời gian:</strong> 60 phút
            </div>
            <div class="info-item">
                <strong>Môn:</strong> Lập trình Android
            </div>
        </div>
        <div class="stats">
            <strong>Chế độ xem:</strong>
            <span id="view-mode">Đáp án đã hiển thị</span>
        </div>

        <div class="question-container <?php echo ($_SERVER['REQUEST_METHOD'] === 'POST') ? '' : 'answer-hidden'; ?>" id="questions-container">
            <?php
            function parseQuizFile($filename) {
                if (!file_exists($filename)) {
                    return [];
                }

                $content = file_get_contents($filename);
                $lines = preg_split('/\r?\n/', $content);

                $questions = [];
                $currentQuestion = [];
                $questionNumber = 1;

                foreach ($lines as $line) {
                    $line = trim($line);

                    if ($line === '') {
                        // blank line => separator between blocks
                        continue;
                    }

                    if (stripos($line, 'ANSWER:') === 0) {
                        $answer = trim(substr($line, 7));
                        $currentQuestion['answer'] = $answer;

                        if (!empty($currentQuestion)) {
                            $currentQuestion['number'] = $questionNumber++;
                            $questions[] = $currentQuestion;
                        }

                        $currentQuestion = [];
                    } elseif (preg_match('/^[A-Z]\.\s*/', $line)) {
                        $currentQuestion['options'][] = $line;
                    } else {
                        if (isset($currentQuestion['text'])) {
                            $currentQuestion['text'] .= ' ' . $line;
                        } else {
                            $currentQuestion['text'] = $line;
                        }
                    }
                }

                return $questions;
            }

            $questions = parseQuizFile('Quiz.txt');
            $totalQuestions = is_array($questions) ? count($questions) : 0;

            $graded = false;
            $score = 0;

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $graded = true;

                foreach ($questions as &$q) {
                    $num = $q['number'];
                    $rawAns = strtoupper(trim($q['answer']));
                    $correct = array_map('trim', array_map('strtoupper', explode(',', $rawAns)));

                    $inputName = 'q' . $num;
                    $user = [];
                    if (isset($_POST[$inputName])) {
                        if (is_array($_POST[$inputName])) {
                            $user = $_POST[$inputName];
                        } else {
                            $user = [$_POST[$inputName]];
                        }
                        $user = array_map('trim', array_map('strtoupper', $user));
                    }

                    $u = $user;
                    sort($u);
                    $c = $correct;
                    sort($c);

                    $isCorrect = ($u === $c);
                    if ($isCorrect) $score++;

                    $q['user'] = $user;
                    $q['correctAnswers'] = $correct;
                    $q['isCorrect'] = $isCorrect;

                    // normalize options into structures for rendering
                    $opts = [];
                    if (isset($q['options'])) {
                        foreach ($q['options'] as $optLine) {
                            $key = strtoupper($optLine[0]);
                            $opts[] = [
                                'text' => $optLine,
                                'key' => $key,
                                'isCorrect' => in_array($key, $correct),
                                'isSelected' => in_array($key, $user),
                            ];
                        }
                    }
                    $q['options'] = $opts;
                }
                unset($q);
            }

            if ($totalQuestions === 0) {
                echo "<div class='question'><p style='color: red;'>File Quiz.txt không tồn tại hoặc không có câu hỏi.</p></div>";
            } else {
                echo "<form method='post' action=''>";

                foreach ($questions as $question) {
                    $isMultiple = strpos($question['answer'], ',') !== false;
                    $questionClass = $isMultiple ? 'multiple-answer' : '';

                    echo "<div class='question {$questionClass}'>";
                    echo "<div class='question-number'>";
                    echo "Câu {$question['number']}:";
                    if ($isMultiple) {
                        echo "<span class='question-type'>Nhiều đáp án</span>";
                    }
                    echo "</div>";
                    echo "<div class='question-text'>{$question['text']}</div>";
                    echo "<ul class='options'>";

                    if (!$graded) {
                        // render inputs
                        if (isset($question['options'])) {
                            foreach ($question['options'] as $opt) {
                                $optText = $opt;
                                $optKey = $opt[0];
                                $inputType = $isMultiple ? 'checkbox' : 'radio';
                                $inputName = 'q' . $question['number'] . ($isMultiple ? '[]' : '');
                                echo "<li class='option'><label><input type='{$inputType}' name='{$inputName}' value='{$optKey}'> {$optText}</label></li>";
                            }
                        }
                    } else {
                        // graded view: options are structured
                        if (isset($question['options'])) {
                            foreach ($question['options'] as $opt) {
                                $classes = '';
                                if ($opt['isCorrect']) $classes .= ' correct';
                                if ($opt['isSelected'] && !$opt['isCorrect']) $classes .= ' incorrect';

                                echo "<li class='option{$classes}'>";
                                echo $opt['text'];
                                if ($opt['isCorrect']) {
                                    echo "<span class='answer-marker'>✓ Đáp án đúng</span>";
                                } elseif ($opt['isSelected'] && !$opt['isCorrect']) {
                                    echo "<span class='answer-marker'>✗</span>";
                                }
                                echo "</li>";
                            }
                        }
                    }

                    echo "</ul>";
                    echo "</div>";
                }

                echo "<div class='controls'>";
                if (!$graded) {
                    echo "<button class='btn btn-toggle' type='submit'>Nộp bài</button>";
                    echo "<button class='btn btn-reset' type='reset'>Xóa chọn</button>";
                } else {
                    echo "<div style='margin-bottom:10px;'><strong>Kết quả:</strong> <span style='color:#2c3e50;'>Bạn đạt <strong>{$score}</strong> / <strong>{$totalQuestions}</strong></span></div>";
                    echo "<a class='btn btn-toggle' href='" . htmlspecialchars($_SERVER['PHP_SELF']) . "'>Làm lại</a>";
                }
                echo "</div>";

                echo "</form>";
            }
            ?>
        </div>

        <div class="controls">
            <button class="btn btn-toggle" onclick="toggleAnswers()">Ẩn/Hiện Đáp Án</button>
            <button class="btn btn-reset" onclick="resetView()">Reset View</button>
        </div>
    </div>
    
    <button class="scroll-top" onclick="scrollToTop()" title="Lên đầu trang">↑</button>

    <script>
        // Cập nhật thông tin tổng số câu hỏi
        document.getElementById('total-questions').textContent = <?php echo $totalQuestions; ?>;
        
        let answersVisible = true;
        
        function toggleAnswers() {
            const container = document.getElementById('questions-container');
            const viewMode = document.getElementById('view-mode');
            
            if (answersVisible) {
                container.classList.add('answer-hidden');
                viewMode.textContent = 'Đáp án đã ẩn';
                answersVisible = false;
            } else {
                container.classList.remove('answer-hidden');
                viewMode.textContent = 'Đáp án đã hiển thị';
                answersVisible = true;
            }
        }
        
        function resetView() {
            const container = document.getElementById('questions-container');
            container.classList.remove('answer-hidden');
            document.getElementById('view-mode').textContent = 'Đáp án đã hiển thị';
            answersVisible = true;
            scrollToTop();
        }
        
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
        
        // Hiển thị nút scroll to top khi cuộn xuống
        window.addEventListener('scroll', function() {
            const scrollBtn = document.querySelector('.scroll-top');
            if (window.scrollY > 300) {
                scrollBtn.style.display = 'block';
            } else {
                scrollBtn.style.display = 'none';
            }
        });
        
        // Ẩn nút scroll to top khi mới tải trang
        document.querySelector('.scroll-top').style.display = 'none';
    </script>
</body>
</html>