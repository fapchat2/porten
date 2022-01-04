
<?php

require 'connect.php';

function mysqliSelect($connection, $select, $s, $txt, $email = null, $phone = null)
{
    $stmt = $connection->prepare($select);

    if (!is_null($email) && !is_null($phone)) {
        $stmt->bind_param($s, $email, $phone);
    } elseif (!is_null($email) && is_null($phone)) {
        $stmt->bind_param($s, $email);
    } elseif (is_null($email) && !is_null($phone)) {
        $stmt->bind_param($s, $phone);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    global $userIsInDatabase;
    $userIsInDatabase = false;

    if ($result->num_rows > 0) {
        swalConfirm($txt);
        $userIsInDatabase = true;
    }
    $stmt->close();
}

function mysqliInsert($connection, $insert, $s, $name = null, $email = null, $phone = null)
{
    $stmt = $connection->prepare($insert);

    if (!is_null($email) && !is_null($phone)) {
        $stmt->bind_param($s, $name, $email, $phone);
    } elseif (!is_null($email) && is_null($phone)) {
        $stmt->bind_param($s, $name, $email);
    } elseif (is_null($email) && !is_null($phone)) {
        $stmt->bind_param($s, $name, $phone);
    }

    $stmt->execute();
    $stmt->close();

}

function swalConfirm($txt)
{
    ?>
  <script>
       let txt = "<?php echo $txt; ?>";
       Swal.fire({text: txt,
           confirmButtonColor: '#e31e35'})
  </script>
<?php

}
if (isset($_POST['name1']) && isset($_POST['email1']) && isset($_POST['phone1'])) {
    mysqliMain($_POST['name1'], $_POST['email1'], $_POST['phone1'], $connection);
}

if (isset($_POST['name0']) && isset($_POST['email0']) && isset($_POST['phone0'])) {
    mysqliMain($_POST['name0'], $_POST['email0'], $_POST['phone0'], $connection);
}

function mysqliMain($name, $email, $phone, $connection)
{
    if (mb_strlen($name) > 1 && !ctype_digit($name) && preg_match('/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[а-яa-z0-9_-]+(\.[а-яa-z0-9_-]+)*\.[a-z]{2,6}$/u', $email) && preg_match('/((8|\+7)-?)?\(?\d{3,5}\)?-?\d{1}-?\d{1}-?\d{1}-?\d{1}-?\d{1}((-?\d{1})?-?\d{1})?/', $phone)) {
        mysqliSelect($connection, "SELECT * FROM users WHERE email = ? OR phone = ?", "ss", 'Вы уже оставили заявку', $email, $phone);
        global $userIsInDatabase;
        if (!$userIsInDatabase) {
            mysqliInsert($connection, "INSERT INTO users (name, email, phone) VALUES (?, ?, ?)", 'sss', $name, $email, $phone);
            swalConfirm('Мы перезвоним Вам, или напишем на Ваш email');
        }

    } else if (mb_strlen($name) > 1 && !ctype_digit($name) && preg_match('/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[а-яa-z0-9_-]+(\.[а-яa-z0-9_-]+)*\.[a-z]{2,6}$/u', $email) && !preg_match('/((8|\+7)-?)?\(?\d{3,5}\)?-?\d{1}-?\d{1}-?\d{1}-?\d{1}-?\d{1}((-?\d{1})?-?\d{1})?/', $phone)) {
        mysqliSelect($connection, "SELECT * FROM `users without phones` WHERE email = ?", "s", 'Вы уже оставили заявку', $email, null);
        global $userIsInDatabase;
        if (!$userIsInDatabase) {
            mysqliSelect($connection, "SELECT * FROM users WHERE email = ?", "s", 'Вы уже оставили заявку', $email, null);
            global $userIsInDatabase;
        }
        if (!$userIsInDatabase) {
            mysqliInsert($connection, "INSERT INTO `users without phones` (name, email) VALUES (?, ?)", 'ss', $name, $email);
            swalConfirm('Мы напишем на Ваш email');
        }
    } else if (mb_strlen($name) > 1 && !ctype_digit($name) && preg_match('/((8|\+7)-?)?\(?\d{3,5}\)?-?\d{1}-?\d{1}-?\d{1}-?\d{1}-?\d{1}((-?\d{1})?-?\d{1})?/', $phone) && !preg_match('/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[а-яa-z0-9_-]+(\.[а-яa-z0-9_-]+)*\.[a-z]{2,6}$/u', $email)) {

        mysqliSelect($connection, "SELECT * FROM `users without emails` WHERE phone = ?", "s", 'Вы уже оставили заявку', null, $phone);
        global $userIsInDatabase;
        if (!$userIsInDatabase) {
            mysqliSelect($connection, "SELECT * FROM users WHERE phone = ?", "s", 'Вы уже оставили заявку', null, $phone);
            global $userIsInDatabase;
        }
        if (!$userIsInDatabase) {
            mysqliInsert($connection, "INSERT INTO `users without emails` (name, phone) VALUES (?, ?)", 'ss', $name, null, $phone);
            swalConfirm('Мы перезвоним Вам');
        }
    } elseif (!preg_match('/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[а-яa-z0-9_-]+(\.[а-яa-z0-9_-]+)*\.[a-z]{2,6}$/u', $email) && !preg_match('/((8|\+7)-?)?\(?\d{3,5}\)?-?\d{1}-?\d{1}-?\d{1}-?\d{1}-?\d{1}((-?\d{1})?-?\d{1})?/', $phone)) {
        swalConfirm('Введите либо имейл, либо телефон, либо и то, и другое');
    } elseif (mb_strlen($name) <= 1 || ctype_digit($name)) {
        swalConfirm('Введите Ваше имя');

    }

}
