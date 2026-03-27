# CLAUDE.md - AI Assistant Guide for Trivia Trader

## Project Overview

**Trivia Trader** is an educational trivia quiz web application with a stock market theme. An admin creates trivia questions and bundles them into quizzes; players take quizzes to earn scores displayed on a leaderboard. Built as a high school student project (student: Todd) following a 13-checkpoint curriculum defined in `agent.md`.

**Current progress:** Checkpoints 1-3 of 13 complete. Admin dashboard and home page are functional; game logic, leaderboard functionality, about page, and helper functions remain unimplemented.

## Tech Stack

- **Language:** PHP 8.2 (vanilla, no frameworks)
- **Frontend:** HTML5, CSS3, minimal vanilla JavaScript
- **Data storage:** JSON flat files (no database)
- **Server:** PHP built-in dev server (`php -S 0.0.0.0:8000 -t .`)
- **Dependencies:** None (no Composer, no npm)
- **Environment:** Replit (Nix-based)

## Project Structure

```
/
├── index.php           # Home page - quiz selection dashboard (COMPLETE)
├── admin.php           # Admin dashboard - question/quiz CRUD (COMPLETE)
├── game.php            # Game interface (EMPTY - needs implementation)
├── leaderboard.php     # Leaderboard display (STUB - empty body)
├── about.php           # Rules and credits page (EMPTY)
├── functions.php       # Shared helper functions (EMPTY)
├── styles.css          # All CSS styling (COMPLETE)
├── data/
│   ├── questions.json  # Question bank (5 sample questions)
│   ├── quizzes.json    # Quiz definitions (empty, admin.php writes here)
│   └── gamePlay.json   # Player score records (12 sample entries)
├── agent.md            # Teaching instructions and checkpoint guide
├── resources.md        # External resource links
├── .replit             # Replit platform config
└── replit.nix          # Nix environment (PHP 8.2)
```

## Running the Project

```bash
php -S 0.0.0.0:8000 -t .
```

Then visit `http://localhost:8000/`.

## Key Routes

| URL | File | Status |
|-----|------|--------|
| `/` or `/index.php` | index.php | Complete |
| `/admin.php` | admin.php | Complete |
| `/game.php?quiz=q_###` | game.php | Empty |
| `/game.php?mode=infinite` | game.php | Empty |
| `/leaderboard.php` | leaderboard.php | Stub |
| `/about.php` | about.php | Empty |

## Data Structures

### questions.json
```json
{
  "id": 1,
  "question": "Question text",
  "options": ["A", "B", "C", "D"],
  "correctAnswer": "A",
  "tags": ["category1", "category2"],
  "difficulty": "easy|medium|hard"
}
```

### quizzes.json
```json
{
  "quizUid": "q_101",
  "quizName": "Quiz Name",
  "category": "Category",
  "questionIds": [1, 2, 3, 4],
  "createdBy": "Creator Name"
}
```

### gamePlay.json
```json
{
  "gameplayUid": "gp_001",
  "quizUid": "q_104",
  "playerName": "Todd",
  "dateTimeStamp": 1772479800,
  "score": 2500,
  "correctStreak": 7,
  "timeLength": 95
}
```

## Scoring System

- 1 point per correct answer
- Every 5 consecutive correct answers = 1 streak
- **Final Score = Total Correct Answers x (Number of Streaks + 1)**

## Code Conventions

- **Procedural PHP** - no classes, no OOP, no namespaces
- **Mixed HTML/PHP** templates (not MVC)
- **Form handling** via `$_POST` / `$_SERVER['REQUEST_METHOD']`
- **JSON I/O** with `json_decode()` / `json_encode(..., JSON_PRETTY_PRINT)`
- **HTML escaping** with `htmlspecialchars()`
- **Stock market themed** UI language (trades, portfolios, market)
- Keep code accessible for a high school student learning PHP

## Important Context

- This is a **student learning project**. Keep code simple and educational.
- `agent.md` contains the full curriculum, checkpoint requirements, and Todd's skill profile. Consult it before making architectural decisions.
- Todd's strongest skills: JSON (5/5), PHP (4/5), HTML (4/5). Weakest: JavaScript (2/5), GitHub (2/5).
- No testing framework is configured; all testing is manual.
- No CI/CD pipeline exists.

## Remaining Work (Checkpoints 4-13)

1. **functions.php** - JSON read/write helpers, shuffle, scoring calculations
2. **game.php** - Full game interface with real-time stats HUD, answer checking, streak tracking
3. **Randomization** - Shuffle questions and answer options
4. **Category filtering** - Filter quizzes by category on home page
5. **Streak multiplier** - Implement the scoring formula in gameplay
6. **Never-Ending Quiz** - Infinite mode using all questions
7. **leaderboard.php** - Display and sort gamePlay.json data
8. **about.php** - Game rules, credits, AI attribution
9. **Player save/load** - Persist player progress
10. **Polish** - Error handling, responsive design, sound effects
11. **Deployment** - GitHub Pages or similar

## Files to Never Modify Without Care

- `agent.md` - Curriculum document, not application code
- `data/*.json` - Persistent data; preserve existing structure and sample data
- `styles.css` - Fully styled; extend rather than rewrite
