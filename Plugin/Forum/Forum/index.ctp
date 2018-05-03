<?= $this->Html->css('Forum.forum-style.css?'.rand(1, 1000000)) ?>
<div class="<?= $theme; ?> marge">
    <div class="row">
        <div class="col-md-10">
            <ol class="forum-breadcrumb">
                <li class="forum-breadcrumb-home-minestorm">
                    <a href="<?= $this->Html->url('/forum') ?>"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
            </ol>
        </div>
        <div class="col-md-2">
            <ol class="forum-breadcrumb">
                <?php if($perms['FORUM_VIEW_REPORT']): ?>
                    <li class="forum-left">
                        <a href="<?= $this->Html->url('/forum/report') ?>"><i class="fa fa-flag" aria-hidden="true"></i></a>
                    </li>
                <?php endif; ?>
                <?php if($active['privatemsg'] && isset($_SESSION['user'])): ?>
                    <li class="forum-left">
                        <a href="<?= $this->Html->url('/message') ?>"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
                    </li>
                <?php endif; ?>
                <?php if(isset($_SESSION['user'])): ?>
                    <li class="forum-left">
                        <a href="<?= $this->Html->url('/user/'.$my['user'].'.'.$my['id'].'/') ?>"><i class="fa fa-user" aria-hidden="true"></i></a>
                    </li>
                    <li class="forum-left last">
                        <a href="<?= $this->Html->url('/user/logout') ?>"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
                    </li>
                <?php else: ?>
                    <li class="forum-left last">
                        <a href="#" data-toggle="modal" data-target="#login"><i class="fa fa-sign-in" aria-hidden="true"></i></a>
                    </li>
                <?php endif; ?>
            </ol>
        </div>
    </div>

    <?= @$this->Session->flash(); ?>
    <?php foreach ($forums as $f => $forum): ?>
        <?php if($forum['Forum']['id_parent'] == 0): $p = $forum['Forum']['id']; ?>
            <div class="forum-forum">
                <div class="forum-forum-header-minestorm">
                    <p class="forum-forum-title-minestorm inline">
                        <?php if(filter_var($forum['Forum']['forum_image'], FILTER_VALIDATE_URL)): ?>
                            <img src="<?= $forum['Forum']['forum_image']; ?>" class="forum-category-icon-min" alt="" />
                        <?php else: ?>
                            <i class="fa fa-<?= $forum['Forum']['forum_image']; ?> forum-category-fa-min-minestorm" aria-hidden="true"></i>
                        <?php endif; ?>
                        <?= $forum['Forum']['forum_name']; ?>
                    </p>
                </div>
            <?php foreach ($forums as $f => $forum): ?>
                <?php if($forum['Forum']['id_parent'] != 0 && $forum['Forum']['id_parent'] == $p): ?>
                    <div class="forum-category-minestorm">
                        <div class="row">
                            <div class="forum-category-icone col-xs-2 col-md-1 text-center">
                                <?php if(filter_var($forum['Forum']['forum_image'], FILTER_VALIDATE_URL)): ?>
                                    <img src="<?= $forum['Forum']['forum_image']; ?>" class="forum-category-icon" alt="" />
                                <?php else: ?>
                                    <i class="fa fa-<?= $forum['Forum']['forum_image']; ?> forum-category-fa-minestorm" aria-hidden="true" style="line-height: 50px;"></i>
                                <?php endif; ?>
                            </div>
                            <div class="col-xs-7 col-md-7 col-sm-6" style="margin-left:-30px;">
                                <h3 class="forum-category-title-minestorm"><a href="<?= $forum['Forum']['href']; ?>"><?= $forum['Forum']['forum_name']; ?></a></h3>
                                <div class="forum-category-description"><span><?= $Lang->get('FORUM__FORUMS__ALT'); ?> :</span> <?= $forum['Forum']['nb_discussion']; ?> <span><?= $Lang->get('FORUM__MSGS'); ?> :</span> <?= $forum['Forum']['nb_message']; ?></div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-3 hidden-mob forum-category-last">
                                <?php if($forum['Forum']['nb_discussion'] != 0 && $forum['Forum']['nb_message'] != 0): ?>
                                <a href="<?= $forum['Forum']['topic_last_href']; ?>"><?= h($forum['Forum']['topic_last_title']); ?></a><br/>
                                <a style="color:#<?= $forum['Forum']['topic_last_author_color']; ?>" href="/user/<?= $forum['Forum']['topic_last_author']; ?>.<?= $forum['Forum']['topic_last_authorid']; ?>/"><?= $forum['Forum']['topic_last_author']; ?></a>, <?= $forum['Forum']['topic_last_date']; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>

    <?php endforeach; ?>
    <?php if($active['statistics']): ?>
    <div class="forum-forum">
        <div class="forum-forum-header-minestorm">
           <i class="fa fa-star-o forum-category-fa-min-minestorm" aria-hidden="true"></i> <?= $Lang->get('FORUM__STATISTIC'); ?>
        </div>
        <div class="forum-category">
            <div class="row">
                <div class="col-md-6 col-xs-12 text-center">
                    <span class="forum-other-stats"><?= $stats['total_topic']; ?></span>
                    <span class="forum-other-stats-txt"><?= $Lang->get('FORUM__TOTAL__TOPIC'); ?></span>
                </div>
                <div class="col-md-6 col-xs-12 text-center">
                    <span class="forum-other-stats"><?= $stats['total_msg']; ?></span>
                    <span class="forum-other-stats-txt"><?= $Lang->get('FORUM__TOTAL__MSG'); ?></span>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if($active['useronline']): ?>
    <div class="row">
        <div class="col-md-12">
            <span><?= $Lang->get('FORUM__USER'); ?><?php if($stats['countuser'] > 1) echo 's'; ?> <?= $Lang->get('FORUM__CONNECTED'); ?><?php if($stats['countuser'] > 1) echo 's'; ?> : </span>
            <?php foreach($userOnlines as $userOnline): ?>
                <a href="/user/<?= $userOnline['User']['pseudo']; ?>.<?= $userOnline['User']['id']; ?>/" style="color: #<?= $userOnline['User']['color']; ?>"><?= $userOnline['User']['pseudo']; ?></a>
            <?php endforeach; ?>
            <?php if($stats['countuser'] == 0) echo 'Aucun utilisateur en ligne actuellement'; ?>
        </div>
    </div>
    <?php endif; ?>
</div>