<ul class="media-list list-items">
    <?php if ($agents): ?>
        <?php
        $agentType = array(
            '1' => 'Sales Agent',
            '2' => 'Verification Agent',
            '3' => 'Processing Agent',
        );
        ?>

        <?php
        foreach ($agents as $agent):
            if ($agent->status == 'READY') {
                $statusClass = 'media-online';
            } elseif ($agent->status == 'INCALL' || $agent->status == 'PAUSED' || $agent->status == 'DISPO' || $agent->status == 'BUSY') {
                $statusClass = 'media-busy';
            } elseif ($agent->status == 'AWAY') {
                $statusClass = 'media-away';
            } elseif ($agent->status == 'LUNCH') {
                $statusClass = 'media-lunch';
            } else {
                $statusClass = 'media-offline';
            }
            if ($agent->id != $this->session->userdata('agent')->id):
                ?>
<!--                <li id="media-<?php echo $agent->id ?>" class="media <?= $statusClass; ?>" data-extension="<?php echo getAgentPhoneExtension($agent->vicidial_user_id) ?>">-->
                <li id="media-<?php echo $agent->id ?>" class="media <?= $statusClass; ?>" data-agent="<?php echo $agent->id; ?>">
                    <div class="media-status">
                        <!--span class="badge badge-success">8</span-->
                    </div>
                    <?php $profileImage = $agent->profile_image; ?>
                    <?php if ($profileImage): ?>
                        <?php $image = site_url() . 'uploads/agents/' . $agent->profile_image ?>
                    <?php else: ?>
                        <?php $image = site_url() . 'uploads/agents/' . 'users.jpg' ?>
                    <?php endif; ?>
                    <img class="media-object" src="<?php echo $image; ?>" alt="...">
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $agent->fname . ' ' . $agent->lname ?><span class="status-text"></span></h4>
                        <div class="media-heading-sub"><?php echo $agentType[$agent->agent_type] ?></div>
                        <div class="media-heading-sub"><a class="select-link" href="#"  style="display:none;"><?php echo "Click For Transfer" ?></a></div>
                    </div>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>