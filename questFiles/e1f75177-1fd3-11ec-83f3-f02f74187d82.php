<?php
if (isset($_POST["answer"]) && $_POST["answer"]) {
    $solution = "panda";
    if ($_POST["answer"] === $solution) {
        $currentUser->completeQuest($currentQuest->id);
        print "You did it!";
    } else print "Wrong answer :(";
}
?>
<form class="quest-form" action="" method="post">
    <label for="answer">Skriv inn svaret</label><br/>
    <input type="text" class="inventory-item-add" placeholder="Svar" name="answer" id="answer"><br/>
    <button type="submit" class="profile-stats-submit">Send inn</button>
</form>