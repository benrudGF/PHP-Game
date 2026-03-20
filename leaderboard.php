<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trivia Trader | Leaderboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
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
        <h2>Top Traders Leaderboard</h2>
        <p>The market's finest — ranked by score.</p>

        <?php
            $gameplay = json_decode(file_get_contents('data/gamePlay.json'), true) ?? [];

            $sortBy = $_GET['sort'] ?? 'score';
            $allowed = ['score', 'playerName', 'correctStreak', 'timeLength'];
            if (!in_array($sortBy, $allowed)) {
                $sortBy = 'score';
            }

            usort($gameplay, function($a, $b) use ($sortBy) {
                if ($sortBy === 'playerName') {
                    return strcasecmp($a['playerName'], $b['playerName']);
                }
                if ($sortBy === 'timeLength') {
                    return $a['timeLength'] - $b['timeLength'];
                }
                return $b[$sortBy] - $a[$sortBy];
            });
        ?>

        <table class="leaderboard-table">
            <thead>
                <tr>
                    <th class="rank-col">Rank</th>
                    <th><a class="sort-link <?= $sortBy === 'playerName' ? 'active-sort' : '' ?>" href="?sort=playerName">Player</a></th>
                    <th><a class="sort-link <?= $sortBy === 'score' ? 'active-sort' : '' ?>" href="?sort=score">Score</a></th>
                    <th><a class="sort-link <?= $sortBy === 'correctStreak' ? 'active-sort' : '' ?>" href="?sort=correctStreak">Streak</a></th>
                    <th><a class="sort-link <?= $sortBy === 'timeLength' ? 'active-sort' : '' ?>" href="?sort=timeLength">Time (s)</a></th>
                    <th>Quiz</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($gameplay as $index => $play): ?>
                    <?php
                        $rank = $index + 1;
                        $rowClass = $rank <= 3 ? 'top-trader' : '';

                        if ($rank === 1) {
                            $medalHtml = '<span class="medal gold">1</span>';
                        } elseif ($rank === 2) {
                            $medalHtml = '<span class="medal silver">2</span>';
                        } elseif ($rank === 3) {
                            $medalHtml = '<span class="medal bronze">3</span>';
                        } else {
                            $medalHtml = $rank;
                        }
                    ?>
                    <tr class="<?= $rowClass ?>">
                        <td class="rank-col"><?= $medalHtml ?></td>
                        <td class="player-name"><?= htmlspecialchars($play['playerName']) ?></td>
                        <td><?= number_format($play['score']) ?></td>
                        <td><?= $play['correctStreak'] ?></td>
                        <td><?= $play['timeLength'] ?>s</td>
                        <td class="quiz-id"><?= htmlspecialchars($play['quizUid']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <footer class="site-footer">
        <div class="footer-content">
            <p>&copy; 2026 Trivia Trader. All Rights Reserved.</p>
            <p>Market data delayed by 0 seconds.</p>
        </div>
    </footer>
</body>
</html>
