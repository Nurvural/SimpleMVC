<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
</head>

<body>
    <h2>User</h2>

    <?php if ($user): ?>
   
            <strong>ID:</strong> <?= htmlspecialchars($user[0]['id']) ?><br>
            <strong>Adı:</strong> <?= htmlspecialchars($user[0]['name']) ?><br>
            <strong>Email:</strong> <?= htmlspecialchars($user[0]['email']) ?>
      
    <?php else: ?>
        <p>User not found.</p>
    <?php endif; ?>
</body>

</html>