<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trivia Trader | Leaderboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <?php
    // ── Load gameplay data ───────────────────────────────────────
    $gameplay = json_decode(file_get_contents('data/gamePlay.json'), true) ?? [];

    // ── Handle sorting via query string ──────────────────────────
    $sortBy = $_GET['sort'] ?? 'score';
    $allowed = ['score', 'playerName', 'correctStreak', 'timeLength'];
    if (!in_array($sortBy, $allowed)) {
        $sortBy = 'score';
    }

    // Sort the gameplay array by the chosen column
    usort($gameplay, function($a, $b) use ($sortBy) {
        if ($sortBy === 'playerName') {
            // Alphabetical A-Z for names
            return strcasecmp($a['playerName'], $b['playerName']);
        }
        if ($sortBy === 'timeLength') {
            // Fastest time first (ascending)
            return $a['timeLength'] - $b['timeLength'];
        }
        // Score and streak: highest first (descending)
        return $b[$sortBy] - $a[$sortBy];
    });
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
            <h2>Market Leaderboard</h2>
            <p>The top traders ranked by performance. Click a column header to re-sort.</p>
        </section>

        <?php if (empty($gameplay)): ?>
            <p class="empty-state">No trades recorded yet. Play a quiz to get on the board!</p>
        <?php else: ?>
            <table class="leaderboard-table">
                <thead>
                    <tr>
                        <th class="rank-col">#</th>
                        <th><a href="leaderboard.php?sort=playerName" class="sort-link <?php echo $sortBy === 'playerName' ? 'active-sort' : ''; ?>">Trader</a></th>
                        <th><a href="leaderboard.php?sort=score" class="sort-link <?php echo $sortBy === 'score' ? 'active-sort' : ''; ?>">Score</a></th>
                        <th><a href="leaderboard.php?sort=correctStreak" class="sort-link <?php echo $sortBy === 'correctStreak' ? 'active-sort' : ''; ?>">Streak</a></th>
                        <th><a href="leaderboard.php?sort=timeLength" class="sort-link <?php echo $sortBy === 'timeLength' ? 'active-sort' : ''; ?>">Time</a></th>
                        <th>Quiz</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($gameplay as $index => $entry): ?>
                    <tr class="<?php echo $index < 3 ? 'top-trader' : ''; ?>">
                        <td class="rank-col">
                            <?php
                            $rank = $index + 1;
                            if ($rank === 1) echo '<span class="medal gold">1</span>';
                            elseif ($rank === 2) echo '<span class="medal silver">2</span>';
                            elseif ($rank === 3) echo '<span class="medal bronze">3</span>';
                            else echo $rank;
                            ?>
                        </td>
                        <td class="player-name"><?php echo htmlspecialchars($entry['playerName']); ?></td>
                        <td><strong><?php echo number_format($entry['score']); ?></strong></td>
                        <td><?php echo $entry['correctStreak']; ?> correct</td>
                        <td><?php echo $entry['timeLength']; ?>s</td>
                        <td class="quiz-id"><?php echo htmlspecialchars($entry['quizUid']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>

    <footer class="site-footer">
        <div class="footer-content">
            <p>&copy; 2026 Trivia Trader. All Rights Reserved.</p>
            <p>Market data delayed by 0 seconds.</p>
        </div>
    </footer>

</body>
</html>
