<?php
echo "<link rel='stylesheet' href='style.css'>";
session_start();
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $messages = array();
    if (!empty($_COOKIE['save'])) {
        setcookie('save', '', 100000);
        setcookie('login', '', 100000);
        setcookie('pass', '', 100000);
        $messages[] = 'Спасибо, результаты сохранены.';
        if (!empty($_COOKIE['pass'])) {
            $messages[] = sprintf('Войдите <a href="login.php">войти</a> с логином <strong>%s</strong>
        и паролем <strong>%s</strong> чтобы измененить данные.',
                strip_tags($_COOKIE['login']),
                strip_tags($_COOKIE['pass']));
        }
        setcookie('fio_value', '', 100000);
        setcookie('email_value', '', 100000);
        setcookie('year_value', '', 100000);
        setcookie('gender_value', '', 100000);
        setcookie('limbs_value', '', 100000);
        setcookie('text_value', '', 100000);
        setcookie('superpower_value', '', 100000);
        setcookie('check_value', '', 100000);
    }
    
    $errors = array();
    $error=FALSE;
    $errors['fio'] = !empty($_COOKIE['fio_error']);
    $errors['email'] = !empty($_COOKIE['email_error']);
    $errors['year'] = !empty($_COOKIE['year_error']);
    $errors['gender'] = !empty($_COOKIE['gender_error']);
    $errors['limbs'] = !empty($_COOKIE['limbs_error']);
    $errors['superpower'] = !empty($_COOKIE['superpower_error']);
    $errors['text'] = !empty($_COOKIE['text_error']);
    $errors['check'] = !empty($_COOKIE['check_error']);
    // Выдаем сообщения об ошибках.
    if (!empty($errors['fio'])) {
        // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('fio_error', '', 100000);
        // Выводим сообщение.
        $messages[] = '<div class="error">Заполните имя.</div>';
    }
    if ($errors['fio']) {
        // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('fio_error', '', 100000);
        // Выводим сообщение.
        $messages[] = '<div class="error">Заполните имя.</div>';
    }
    // TODO: тут выдать сообщения об ошибках в других полях.
    if ($errors['email']) {
        // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('email_error', '', 100000);
        // Выводим сообщение.
        $messages[] = '<div class="error">Заполните email.</div>';
    }
    if ($errors['year']) {
        // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('year_error', '', 100000);
        // Выводим сообщение.
        $messages[] = '<div class="error">Выберите год.</div>';
    }
    
    if ($errors['gender']) {
        // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('gender_error', '', 100000);
        // Выводим сообщение.
        $messages[] = '<div class="error">Выберите пол.</div>';
    }
    if ($errors['limbs']) {
        // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('limbs_error', '', 100000);
        // Выводим сообщение.
        $messages[] = '<div class="error">Выберите конечности.</div>';
    }
    if ($errors['superpower']) {
        // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('superpower_error', '', 100000);
        // Выводим сообщение.
        $messages[] = '<div class="error">Выберите сверхспособность.</div>';
    }
    if ($errors['text']) {
        // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('text_error', '', 100000);
        // Выводим сообщение.
        $messages[] = '<div class="error">Впишите био.</div>';
    }
    if ($errors['check']) {
        setcookie('check_error', '', 100000);
        $messages[] = '<div class="pas error">Ознакомтесь с контрактом.</div>';
    }
    $values = array();
    $values['fio'] = empty($_COOKIE['fio_value']) ? '' : strip_tags($_COOKIE['fio_value']);
    $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
    $values['year'] = empty($_COOKIE['year_value']) ? '' : $_COOKIE['year_value'];
    $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
    $values['superpower'] = empty($_COOKIE['superpower_value']) ? '' : $_COOKIE['superpower_value'];
    $values['limbs'] = empty($_COOKIE['limbs_value']) ? '' : $_COOKIE['limbs_value'];
    $values['text'] = empty($_COOKIE['text_value']) ? '' : $_COOKIE['text_value'];
    $values['check'] = empty($_COOKIE['check_value']) ? 0 : $_COOKIE['check_value'];
    
    // Если нет предыдущих ошибок ввода, есть кука сессии, начали сессию и
    // ранее в сессию записан факт успешного логина.
    if (!$error && !empty($_COOKIE[session_name()]) && !empty($_SESSION['login'])) {
        $user = 'u52813';
        $pass = '9339974';
        $db = new PDO('mysql:host=localhost;dbname=u52813', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
        try{
            $get=$db->prepare("SELECT * FROM form WHERE id=?");
            $get->bindParam(1,$_SESSION['uid']);
            $get->execute();
            $inf=$get->fetchALL();
            $values['fio']=$inf[0]['name'];
            $values['email']=$inf[0]['email'];
            $values['year']=$inf[0]['year'];
            $values['gender']=$inf[0]['pol'];
            $values['limbs']=$inf[0]['limbs'];
            $values['text']=$inf[0]['bio'];
            
            $get2=$db->prepare("SELECT id_sup FROM Sform WHERE id_per=?");
            $get2->bindParam(1,$_SESSION['uid']);
            $get2->execute();
            $inf2=$get2->fetchALL();
                if($inf2[0]['id_sup']=='10'){
                    $values['superpower'] == 't';
                }
                if($inf2[0]['id_sup']=='20'){
                    $values['superpower'] == 'b';
                }
                if($inf2[0]['id_sup']=='30'){
                    $values['superpower'] == 'c';
                }
                if($inf2[0]['id_sup']=='40'){
                    $values['superpower'] == 'p';
                }
        }
        catch(PDOException $e){
            print('Error: '.$e->getMessage());
            exit();
        }
        printf('Произведен вход с логином %s, uid %d', $_SESSION['login'], $_SESSION['uid']);
    }
    
    // Включаем содержимое файла form.php.
    // В нем будут доступны переменные $messages, $errors и $values для вывода
    // сообщений, полей с ранее заполненными данными и признаками ошибок.
    include('form.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else {
    if(isset($_POST['logout'])){
        session_destroy();
        header('Location: index.php');
    }
    // Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
    // Проверяем ошибки.
    $errors = FALSE;
    if (empty($_POST['fio'])) {
        // Выдаем куку на день с флажком об ошибке в поле fio.
        setcookie('fio_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    else {
        // Сохраняем ранее введенное в форму значение на месяц.
        setcookie('fio_value', $_POST['fio'], time() + 30 * 24 * 60 * 60);
    }
    
    $errors = FALSE;
    if (empty($_POST['email'])) {
        // Выдаем куку на день с флажком об ошибке в поле fio.
        setcookie('email_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    else {
        // Сохраняем ранее введенное в форму значение на месяц.
        setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
    }
    
    if (($_POST['year'] < 1922) || !is_numeric($_POST['year']) || !preg_match('/^\d+$/', $_POST['year'])) {
        setcookie('year_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        // Сохраняем ранее введенное в форму значение на месяц.
        setcookie('year_value', $_POST['year'], time() + 30 * 24 * 60 * 60);
    }
    if (empty($_POST['gender'])) {
        setcookie('gender_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        // Сохраняем ранее введенное в форму значение на месяц.
        setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);
    }
    if (empty($_POST['superpower'])) {
        setcookie('superpower_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        // Сохраняем ранее введенное в форму значение на месяц.
        setcookie('superpower_value', $_POST['superpower'], time() + 30 * 24 * 60 * 60);
    }
    
    if (empty($_POST['text'])) {
        setcookie('text_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        // Сохраняем ранее введенное в форму значение на месяц.
        setcookie('text_value', $_POST['text'], time() + 30 * 24 * 60 * 60);
    }
    if (empty($_POST['limbs'])) {
        setcookie('limbs_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        // Сохраняем ранее введенное в форму значение на месяц.
        setcookie('limbs_value', $_POST['limbs'], time() + 30 * 24 * 60 * 60);
        //checked( 'limbs_value', $_POST['limbs'], 'limbs_value' );
    }
    if(empty($_SESSION['login'])){
        if(!isset($_POST['check'])){
            setcookie('check_error','1',time()+ 24*60*60);
            setcookie('check_value', '', 100000);
            $errors=TRUE;
        }
        else{
            setcookie('check_value',TRUE,time()+ 60*60);
            setcookie('check_error','',100000);
        }
    }
    
    if ($errors) {
        // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
        header('Location: login.php');
    }
    else {
        // Удаляем Cookies с признаками ошибок.
        setcookie('fio_error', '', 100000);
        setcookie('email_error', '', 100000);
        setcookie('year_error', '', 100000);
        setcookie('gender_error', '',100000);
        setcookie('limbs_error', '',100000);
        setcookie('superpower_error', '', 100000);
        setcookie('text_error', '', 100000);
        setcookie('check_error', '', 100000);
    }
            
            $user = 'u52813';
            $pass = '9339974';
            $db = new PDO('mysql:host=localhost;dbname=u52813', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
            if (!empty($_COOKIE[session_name()]) && !empty($_SESSION['login']) and !$errors) {
                $id=$_SESSION['uid'];
                $upd=$db->prepare("UPDATE form SET name=:name, email=:email, year=:byear, pol=:pol, limbs=:limbs, bio=:bio WHERE id=:id");
                $cols=array(
                    ':name'=>$_POST['fio'],
                    ':email'=>$_POST['email'],
                    ':byear'=>$_POST['year'],
                    ':pol'=>$_POST['gender'],
                    ':limbs'=>$_POST['limbs'],
                    ':bio'=>$_POST['text']
                );
                foreach($cols as $k=>&$v){
                    $upd->bindParam($k,$v);
                }
                $upd->bindParam(':id',$id);
                $upd->execute();
                $del=$db->prepare("DELETE FROM Sform WHERE id_per=?");
                $del->execute(array($id));
                $stmt = $db->prepare("INSERT INTO Sform SET id_per = ?, id_sup = ?");
                if ($_POST['superpower']=='t')
                {$stmt -> execute([$id, 10]);}
                else if ($_POST['superpower']=='b')
                {$stmt -> execute([$id, 20]);}
                else if ($_POST['superpower']=='c')
                {$stmt -> execute([$id, 30]);}
                else if ($_POST['superpower']=='p')
                {$stmt -> execute([$id, 40]);}
            }
            else {
                if(!$errors){
                    $login = 'u'.substr(uniqid(),-5);
                    $pass = substr(md5(uniqid()),0,10);
                    $pass_hash=password_hash($pass,PASSWORD_DEFAULT);
                    setcookie('login', $login);
                    setcookie('pass', $pass);
                    
                    try {
                        $stmt = $db->prepare("INSERT INTO form SET name=:name, email=:email, year=:byear, pol=:pol, limbs=:limbs, bio=:bio");
                        $stmt->bindParam(':name',$_POST['fio']);
                        $stmt->bindParam(':email',$_POST['email']);
                        $stmt->bindParam(':byear',$_POST['year']);
                        $stmt->bindParam(':pol',$_POST['gender']);
                        $stmt->bindParam(':limbs',$_POST['limbs']);
                        $stmt->bindParam(':bio',$_POST['text']);
                        $stmt -> execute();
                        
                        $id=$db->lastInsertId();
                        
                        $usr=$db->prepare("INSERT INTO login SET id=?,login=?,password=?");
                        $usr->bindParam(1,$id);
                        $usr->bindParam(2,$login);
                        $usr->bindParam(3,$pass_hash);
                        $usr->execute();
                        
                        $stmt = $db->prepare("INSERT INTO Sform SET id_per = ?, id_sup = ?");
                        if ($_POST['superpower']=='t')
                            {$stmt -> execute([$id, 10]);}
                            else if ($_POST['superpower']=='b')
                            {$stmt -> execute([$id, 20]);}
                            else if ($_POST['superpower']=='c')
                            {$stmt -> execute([$id, 30]);}
                            else if ($_POST['superpower']=='p')
                            {$stmt -> execute([$id, 40]);}
                      
                    }
                    catch(PDOException $e){
                        print('Error : ' . $e->getMessage());
                        exit();
                    }
                }
            }
            if(!$errors){
                setcookie('save', '1');
            }
            header('Location: ./');
    }
