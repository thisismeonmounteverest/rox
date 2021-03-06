
    <!-- #main: content begins here -->
    <div id="main" class="mt-4">
        <?php $this->topnav() ?>
        <?php $this->statusMessage() ?>
        <?php $loginMessages = $this->_getLoginMessages();
            if (!empty($loginMessages)) :
                foreach($loginMessages as $id => $loginMessage) : ?>
            <div class="loginmessage">
                <a href="/close/<?= $id ?>" class="boxclose"></a>
                <?= $loginMessage ?>
            </div>
        <?php
            endforeach;
            endif; ?>

            <?php $this->teaser() ?>

        <?php if ($this->getFlashError()): ?>
            <div class="flash error"><?php echo $this->getFlashError(true); ?></div>
        <?php endif; ?>
        <?php if ($this->getFlashNotice()): ?>
        <div class="flash notice"><?php echo $this->getFlashNotice(true); ?></div>
        <?php endif; ?>

        <?php $this->columnsArea() ?>
    </div> <!-- main -->

<div>
    <?php $this->debugInfo() ?>
    <?php $this->leftoverTranslationLinks() ?>
</div>
