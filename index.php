<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trivia Trader | Home</title>
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
                  <a href="about.php">Admin</a>
              </nav>
          </div>
      </header>

    <main class="container">
        <section class="hero">
            <h2>Invest in your Knowledge</h2>
            <p>Select a quiz to start trading facts for points.</p>
            <a href="game.php?mode=infinite" class="btn-primary">Start Never-Ending Quiz</a>
        </section>

        <h3>Available Quizzes</h3>

        <section class="quiz-grid">

            <div class="quiz-card">
                <span class="category-tag">Finance</span>
                <h3>Blue Chip Stocks</h3>
                <p>Test your knowledge on the world's biggest companies.</p>
                <a href="game.php?quiz=q_104" class="btn-outline">Trade Quiz</a>
            </div>

            <div class="quiz-card">
                <span class="category-tag">Tech</span>
                <h3>Silicon Valley</h3>
                <p>Do you know your tech giants?</p>
                <a href="game.php?quiz=q_105" class="btn-outline">Trade Quiz</a>
            </div>

            <div class="quiz-card">
                <span class="category-tag">History</span>
                <h3>Market Crashes</h3>
                <p>Learn from the bears of the past.</p>
                <a href="game.php?quiz=q_106" class="btn-outline">Trade Quiz</a>
            </div>

            <div class="quiz-card">
                <span class="category-tag">Vocab</span>
                <h3>Trader Lingo</h3>
                <p>Bulls, bears, and short squeezes.</p>
                <a href="game.php?quiz=q_107" class="btn-outline">Trade Quiz</a>
            </div>

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