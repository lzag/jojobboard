<?php require_once 'header.php'; ?>
<?php $employer = new Employer; ?>

<div class="container">
    <div class="col w-75 m-auto">
        <p class="text-dark">Company Tax ID: <?= $employer->getProperty('tax_id') ?></p>
        <p class="text-dark">Contact First Name: <?= $employer->getProperty('contact_first_name') ?></p>
        <p class="text-dark">Contact Last Name: <?= $employer->getProperty('contact_second_name') ?></p>
        <p class="text-dark">Contact Email: <?= $employer->getProperty('contact_email') ?></p>
        <p ><a href='removeaccount.php' class="text-danger"> Remove Account </a></p>
    </div>
</div>
<div class="container">
    <div class="col w-75 m-auto">
        <h3>Posted offers and applications:</h3>
            <?php
                if ($result = $employer->getPostings()) :
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) :
                    foreach ($row as $key => $value) : ?>
                    <h6 class="text-dark"><?php echo $key. " : " . $value ; ?> </h6>
                    <?php endforeach; ?>
                    <?php
                    echo "<a href='reviewapplications.php?posting={$row['ID']}'>Review applications</a>";
                    echo "<br><br>";
                    endwhile;
                endif; ?>
    </div>
</div>

<?php require_once 'footer.php'; ?>
