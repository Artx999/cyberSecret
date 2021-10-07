<?php
if (isset($_POST["answer"]) && $_POST["answer"]) {
    $solution = "panda";
    if ($_POST["answer"] === $solution) {
        $currentUser->completeQuest($currentQuest->id);
        print "You did it!";
    } else print "Wrong answer :(";
}
?>
<form action="" method="post">
    <label for="answer">Skriv inn svaret</label><br/>
    <input type="text" name="answer" id="answer"><br/>
    <button type="submit">Send inn</button>
</form>