<?php
$logFile = __DIR__ . '/logs.json';
$logs = file_exists($logFile)
    ? json_decode(file_get_contents($logFile), true)
    : ['myths' => [], 'feedback' => []];

$myths = array_reverse($logs['myths'] ?? []);
$feedback = array_reverse($logs['feedback'] ?? []);

function e($val) {
    return htmlspecialchars((string)$val, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Antarctica Site — Saved Logs</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #0f172a;
      color: #e2e8f0;
      margin: 0;
      padding: 24px;
    }
    .container { max-width: 1000px; margin: 0 auto; }
    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 12px;
      margin-bottom: 24px;
    }
    h1 { margin: 0; font-size: 24px; color: #38bdf8; }
    h2 { margin: 28px 0 10px; font-size: 18px; color: #f8fafc; }
    .btn {
      display: inline-block;
      padding: 8px 14px;
      background: #0284c7;
      color: #fff;
      text-decoration: none;
      border-radius: 6px;
      font-size: 14px;
    }
    .btn.secondary { background: #334155; }
    table {
      width: 100%;
      border-collapse: collapse;
      background: #1e293b;
      border-radius: 8px;
      overflow: hidden;
      margin-bottom: 24px;
    }
    th, td {
      padding: 10px 12px;
      text-align: left;
      border-bottom: 1px solid #334155;
      font-size: 14px;
      vertical-align: top;
    }
    th { background: #0f172a; color: #7dd3fc; font-weight: 600; }
    tr:last-child td { border-bottom: none; }
    .empty {
      padding: 16px;
      background: #1e293b;
      border-radius: 8px;
      color: #94a3b8;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="top-bar">
      <h1>Antarctica Atlas — Stored Logs</h1>
      <div>
        <a class="btn secondary" href="index.html">Back to Website</a>
        <a class="btn" href="view_logs.php">Refresh</a>
      </div>
    </div>

    <h2>Submitted Myths (<?= count($myths) ?>)</h2>
    <?php if (empty($myths)): ?>
      <div class="empty">No myth submissions yet.</div>
    <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>Date &amp; Time</th>
            <th>Name</th>
            <th>Myth Title</th>
            <th>Category</th>
            <th>Details</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($myths as $item): ?>
            <tr>
              <td><?= e($item['submitted_at'] ?? '') ?></td>
              <td><?= e($item['name'] ?? '') ?></td>
              <td><?= e($item['myth_title'] ?? '') ?></td>
              <td><?= e($item['category'] ?? '') ?></td>
              <td><?= e($item['details'] ?? '') ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>

    <h2>Feedback &amp; Queries (<?= count($feedback) ?>)</h2>
    <?php if (empty($feedback)): ?>
      <div class="empty">No feedback or queries yet.</div>
    <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>Date &amp; Time</th>
            <th>Name</th>
            <th>Email</th>
            <th>Topic</th>
            <th>Message</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($feedback as $item): ?>
            <tr>
              <td><?= e($item['submitted_at'] ?? '') ?></td>
              <td><?= e($item['name'] ?? '') ?></td>
              <td><?= e($item['email'] ?? '') ?></td>
              <td><?= e($item['topic'] ?? '') ?></td>
              <td><?= e($item['message'] ?? '') ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</body>
</html>