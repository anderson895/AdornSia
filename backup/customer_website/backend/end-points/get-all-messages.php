<?php
session_start();
include('../class.php');
$db = new global_class();

$acc_id = $_SESSION['acc_id'];

if (isset($_SESSION['acc_id'])) {
    if (isset($_GET['requestType'])) {
        if ($_GET['requestType'] == 'getAllMessages') {

            $getAllMessages = $db->getAllMessages($acc_id);

            if ($getAllMessages->num_rows > 0) {
                while ($messages = $getAllMessages->fetch_assoc()) {
                    // Format the date
                    $message_date = date('F j, Y, g:i a', strtotime($messages['mess_date']));

                    if ($messages['mess_sender'] == $acc_id) {
?>
                        <!-- Customer message -->
                        <li class="d-flex justify-content-between mb-4">
                            <div class="card mask-custom w-100" style="background-color:#0084ff;">
                                <div class="card-header d-flex justify-content-between p-3" style="border-bottom: 1px solid rgba(255,255,255,.3);">
                                    <p class="fw-bold mb-0 text-white"><?= ucfirst($messages['acc_fname']) ?> <?= $messages['acc_lname'] ?> (Customer)</p>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0 text-white"><?= $messages['mess_content'] ?></p>
                                    
                                    <!-- Display message image if it exists with fixed size -->
                                    <?php if (!empty($messages['mess_img'])): ?>
                                        <div class="d-flex align-items-center mt-2">
                                            <img src="../upload_message/<?= htmlspecialchars($messages['mess_img']) ?>" alt="message image"
                                                 class="img-fluid" style="width: 100px; height: 100px; object-fit: cover;">
                                            <!-- Download icon -->
                                            <a href="../upload_message/<?= $messages['mess_img'] ?>" 
                                               download 
                                               class="btn btn-link text-white ms-2 p-0" 
                                               title="Download Image">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                    <p class="text-light small mt-2 mb-0 text-end"><i class="far fa-clock"></i> <?= $message_date ?></p>
                                </div>
                            </div>
                            <?php if (!empty($messages['emp_image'])): ?>
                                <img src="../upload_img/<?= htmlspecialchars($messages['emp_image']) ?>" alt="avatar"
                                     class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" style="width: 60px; height: 60px; object-fit: cover;">
                            <?php else: ?>
                                <i class="bi bi-person-fill d-flex align-self-start ms-3" style="font-size: 60px; background-color:black; border-radius:50px;"></i>
                            <?php endif; ?>
                        </li>

                    <?php
                    } else {
                    ?>

                        <!-- Admin message -->
                        <li class="d-flex justify-content-between mb-4">
                            <?php if (!empty($messages['emp_image'])): ?>
                                <img src="../upload_img/<?= htmlspecialchars($messages['emp_image']) ?>" alt="avatar"
                                     class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" style="width: 60px; height: 60px; object-fit: cover;">
                            <?php else: ?>
                                <i class="bi bi-person-fill d-flex align-self-start me-3" style="font-size: 60px; background-color:black; border-radius:50px;"></i>
                            <?php endif; ?>
                            <div class="card mask-custom w-100">
                                <div class="card-header d-flex justify-content-between p-3"
                                     style="border-bottom: 1px solid rgba(255,255,255,.3);">
                                    <p class="fw-bold mb-0"><?= ucfirst($messages['acc_fname']) ?> <?= $messages['acc_lname'] ?> (Administrator)</p>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0">
                                        <?= $messages['mess_content'] ?>
                                    
                                    
                                    </p>
                                    
                                    <!-- Display message image if it exists with fixed size -->
                                    <?php if (!empty($messages['mess_img'])): ?>
                                        <div class="d-flex align-items-center mt-2">
                                            <img src="../upload_message/<?= htmlspecialchars($messages['mess_img']) ?>" alt="message image"
                                                 class="img-fluid" style="width: 100px; height: 100px; object-fit: cover;">
                                            <!-- Download icon -->
                                            <a href="../upload_message/<?= $messages['mess_img'] ?>" 
                                               download 
                                               class="btn btn-link text-secondary ms-2 p-0" 
                                               title="Download Image">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                    <p class="text-secondary small mt-2 mb-0 text-end"><i class="far fa-clock"></i> <?= $message_date ?></p>
                                </div>
                            </div>
                        </li>

                    <?php
                    }
                }
            } else {
                ?>
                <center class="pt-5 pb-5 mt-5 mb-5 text-primary">No Message Found.</center>
                <?php
            }
        }
    }
}
?>
