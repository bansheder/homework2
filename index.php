<!DOCTYPE html>
<html lang="ru">
<head> 
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Гостевая книга</title>
</head>
<body>
    <div class="pictr"><img src="logo.png" alt="Logo"></div>
    
    <div class="container">
        <div class="form-container">
            <form action="" method="POST">
                <input type="text" placeholder="Имя:" id="name" name="name" required><br><br>
                <input type="email" placeholder="Почта:" id="email" name="email" required><br><br>
                <textarea id="message" placeholder="Сообщение:" name="message" rows="5" cols="40" required></textarea><br><br>
                <input type="submit" value="Отправить">
            </form>
        </div>
        
        <div class="messages-container">
            <h2>Сообщения</h2>
            <?php
$filename = "data.txt";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $message = trim($_POST["message"]);

    if (!empty($name) && !empty($email) && !empty($message)) {
        $dateTime = new DateTime('now', new DateTimeZone('Europe/Moscow'));
        $formatDateTime = $dateTime->format('Y-m-d H:i:s');
        $message = htmlspecialchars($message); 
        $message = str_replace("\n", "[NEWLINE]", $message); 
        $entry = implode("~~~", [$name, $email, $formatDateTime, $message]) . "\n";

        file_put_contents($filename, $entry, FILE_APPEND | LOCK_EX);
    }
}

if (file_exists($filename)) {
    $entries = array_reverse(file($filename));
    foreach ($entries as $entry) {
        $fields = explode("~~~", $entry);
        if (count($fields) === 4) {
            list($name, $email, $dateTime, $message) = $fields;
            $message = str_replace("[NEWLINE]", "\n", $message);
            $message = nl2br($message); 

            echo "
                <div class='message-container'>
                    <div>
                        <strong>$name</strong> <em>$email</em>
                    </div>
                    <div>$message</div>
                    <em>$dateTime</em>
                </div>
                <hr>";
        }
    }
}
?>


        </div>
    </div>
</body>
</html>

