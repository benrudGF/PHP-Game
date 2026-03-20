<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trivia Trader | Admin</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <?php
    // ── Handle Form Submissions ──────────────────────────────────
    $message = '';

    // Handle new question submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

        if ($_POST['action'] === 'add_question') {
            // Read existing questions from the JSON file
            $questionsFile = 'data/questions.json';
            $questions = json_decode(file_get_contents($questionsFile), true) ?? [];

            // Generate the next ID by finding the current max
            $maxId = 0;
            foreach ($questions as $q) {
                if ($q['id'] > $maxId) {
                    $maxId = $q['id'];
                }
            }

            // Build the new question array from form data
            $newQuestion = [
                'id' => $maxId + 1,
                'question' => trim($_POST['question']),
                'options' => [
                    trim($_POST['option1']),
                    trim($_POST['option2']),
                    trim($_POST['option3']),
                    trim($_POST['option4'])
                ],
                'correctAnswer' => trim($_POST['correctAnswer']),
                'tags' => array_map('trim', explode(',', $_POST['tags'])),
                'difficulty' => $_POST['difficulty']
            ];

            // Append to the array and save back to file
            $questions[] = $newQuestion;
            file_put_contents($questionsFile, json_encode($questions, JSON_PRETTY_PRINT));
            $message = '✅ Question #' . $newQuestion['id'] . ' added to the market!';
        }

        if ($_POST['action'] === 'create_quiz') {
            // Read existing quizzes from the JSON file
            $quizzesFile = 'data/quizzes.json';
            $quizzes = json_decode(file_get_contents($quizzesFile), true) ?? [];

            // Generate a unique quiz ID (q_101, q_102, etc.)
            $maxNum = 100;
            foreach ($quizzes as $quiz) {
                $num = intval(str_replace('q_', '', $quiz['quizUid']));
                if ($num > $maxNum) {
                    $maxNum = $num;
                }
            }

            // Parse the comma-separated question IDs into an integer array
            $questionIds = array_map('intval', explode(',', $_POST['questionIds']));

            // Build the new quiz array
            $newQuiz = [
                'quizUid' => 'q_' . ($maxNum + 1),
                'quizName' => trim($_POST['quizName']),
                'category' => trim($_POST['category']),
                'questionIds' => $questionIds,
                'createdBy' => trim($_POST['createdBy'])
            ];

            // Append and save
            $quizzes[] = $newQuiz;
            file_put_contents($quizzesFile, json_encode($quizzes, JSON_PRETTY_PRINT));
            $message = '✅ Quiz "' . htmlspecialchars($newQuiz['quizName']) . '" is now listed on the exchange!';
        }
    }

    // ── Load existing data for display ───────────────────────────
    $questions = json_decode(file_get_contents('data/questions.json'), true) ?? [];
    $quizzes = json_decode(file_get_contents('data/quizzes.json'), true) ?? [];
    ?>

    <header class="site-header">
        <div class="header-content">
            <div class="logo"><strong>Trivia</strong>Trader</div>
            <div class="search-bar"><input type="text" placeholder="Search quizzes..."></div>
            <nav class="main-nav">
                <a href="index.php">Dashboard</a>
                <a href="leaderboard.php">Leaderboard</a>
                <a href="about.php">Market Rules</a>
                <a href="admin.php">Admin</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="hero">
            <h2>Creator Dashboard</h2>
            <p>Manage your trivia assets. Add questions and build quizzes from here.</p>
        </section>

        <?php if ($message): ?>
            <div class="admin-alert"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- ── Section 1: Add a New Question ──────────────────── -->
        <div class="admin-grid">
            <div class="admin-card">
                <h3>📝 New Question (IPO)</h3>
                <p class="admin-subtitle">Add a new trivia question to the database.</p>

                <form method="POST" action="admin.php" class="admin-form">
                    <input type="hidden" name="action" value="add_question">

                    <label for="question">Question Text</label>
                    <input type="text" id="question" name="question" placeholder="What is the ticker symbol for Apple Inc.?" required>

                    <label>Answer Options</label>
                    <div class="options-grid">
                        <input type="text" name="option1" placeholder="Option A" required>
                        <input type="text" name="option2" placeholder="Option B" required>
                        <input type="text" name="option3" placeholder="Option C" required>
                        <input type="text" name="option4" placeholder="Option D" required>
                    </div>

                    <label for="correctAnswer">Correct Answer</label>
                    <input type="text" id="correctAnswer" name="correctAnswer" placeholder="Must match one of the options exactly" required>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="tags">Tags (comma-separated)</label>
                            <input type="text" id="tags" name="tags" placeholder="finance, stocks, vocab">
                        </div>
                        <div class="form-group">
                            <label for="difficulty">Difficulty</label>
                            <select id="difficulty" name="difficulty">
                                <option value="easy">Easy</option>
                                <option value="medium">Medium</option>
                                <option value="hard">Hard</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary">List Question on Market</button>
                </form>
            </div>

            <!-- ── Section 2: Build a Quiz ────────────────────── -->
            <div class="admin-card">
                <h3>📦 Build a Quiz (Bundle)</h3>
                <p class="admin-subtitle">Bundle existing questions into a tradeable quiz.</p>

                <form method="POST" action="admin.php" class="admin-form">
                    <input type="hidden" name="action" value="create_quiz">

                    <label for="quizName">Quiz Name</label>
                    <input type="text" id="quizName" name="quizName" placeholder="Blue Chip Stocks" required>

                    <label for="category">Category</label>
                    <input type="text" id="category" name="category" placeholder="Finance" required>

                    <label for="questionIds">Question IDs (comma-separated)</label>
                    <input type="text" id="questionIds" name="questionIds" placeholder="1, 2, 3, 4" required>

                    <label for="createdBy">Created By</label>
                    <input type="text" id="createdBy" name="createdBy" placeholder="Todd" required>

                    <button type="submit" class="btn-primary">List Quiz on Exchange</button>
                </form>

                <!-- Show existing questions so the creator knows which IDs to use -->
                <div class="question-bank">
                    <h4>Available Questions (ID Reference)</h4>
                    <?php if (empty($questions)): ?>
                        <p class="empty-state">No questions in the database yet. Add some above!</p>
                    <?php else: ?>
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Question</th>
                                    <th>Tags</th>
                                    <th>Difficulty</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($questions as $q): ?>
                                <tr>
                                    <td><strong><?php echo $q['id']; ?></strong></td>
                                    <td><?php echo htmlspecialchars($q['question']); ?></td>
                                    <td><?php echo htmlspecialchars(implode(', ', $q['tags'])); ?></td>
                                    <td><?php echo htmlspecialchars($q['difficulty']); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- ── Section 3: Existing Quizzes ────────────────────── -->
        <section class="admin-section">
            <h3>📊 Listed Quizzes</h3>
            <?php if (empty($quizzes)): ?>
                <p class="empty-state">No quizzes created yet. Build your first quiz above!</p>
            <?php else: ?>
                <div class="quiz-grid">
                    <?php foreach ($quizzes as $quiz): ?>
                    <div class="quiz-card">
                        <span class="category-tag"><?php echo htmlspecialchars($quiz['category']); ?></span>
                        <h3><?php echo htmlspecialchars($quiz['quizName']); ?></h3>
                        <p><?php echo count($quiz['questionIds']); ?> questions &middot; by <?php echo htmlspecialchars($quiz['createdBy']); ?></p>
                        <a href="game.php?quiz=<?php echo $quiz['quizUid']; ?>" class="btn-outline">Trade Quiz</a>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <footer class="site-footer">
        <div class="footer-content">
            <p>&copy; 2026 Trivia Trader. All Rights Reserved.</p>
            <p>Market data delayed by 0 seconds.</p>
        </div>
    </footer>

</body>
</html>
