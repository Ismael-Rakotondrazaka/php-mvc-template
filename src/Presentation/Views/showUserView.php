<?php

?>

<h1>
    <?= $user["name"]["full"]; ?>
</h1>

<ul>
    <li>id:
        <?= $user["id"] ?>
    </li>
    <li>First name:
        <?= $user["name"]["first"] ?>
    </li>
    <li>Last name:
        <?= $user["name"]["last"] ?>
    </li>
    <li>Email:
        <?= $user["email"] ?>
    </li>
    <li>CreatedAt:
        <?= $user["createdAt"]->format(DateTime::ATOM) ?>
    </li>
    <li>UpdatedAt:
        <?= $user["updatedAt"]->format(DateTime::ATOM) ?>
    </li>
</ul>