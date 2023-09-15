<?php

$user = $result['data']['user'];

// var_dump($user); die;
?>

<div class="container-category">
    <div class="banner">

        <h1>Mon profil</h1>

    </div>



    <table>
        <thead>
            <tr>
                <th>Pseudo</th>
                <th>Mail</th>
                <th>Date d'inscription</th>
            </tr>
        </thead>
        <tbody>
            <tr>

                <td> <?=$user->getPseudo()?></td>
                <td>Modifier mon pseudo</td>
                <td><?=$user->getEmail()?> </td>
                <td><?=$user->getCreationDate()?> </td>
            </tr>    

        </tbody>


    </table>
</div>