<?php
list($directTranslations, $indirectTranslations) = $sentences->segregateTranslations(
    $translations
);
$maxDisplayed = 5;
$displayedTranslations = 0;
$showExtra = '';
$numExtra = count($directTranslations) + count($indirectTranslations) - $maxDisplayed;
$sentenceLink = $html->link(
    '#'.$sentence['id'],
    array(
        'controller' => 'sentences',
        'action' => 'show',
        $sentence['id']
    )
);
$userLink = $html->link(
    $user['username'],
    array(
        'controller' => 'user',
        'action' => 'profile',
        $user['username']
    )
);
$sentenceUrl = $html->url(array(
    'controller' => 'sentences',
    'action' => 'show',
    $sentence['id']
));
?>
<div class="sentence-and-translations" md-whiteframe="1" ng-cloak>
    <div layout="column">
        <md-subheader>
            <?=
            format(
                __('Sentence {number} — belongs to {username}', true),
                array(
                    'number' => $sentenceLink,
                    'username' => $userLink
                )
            );
            ?>
        </md-subheader>
        <div class="sentence" layout="row" layout-align="start center">
            <div class="lang">
                <?
                echo $languages->icon(
                    $sentence['lang'],
                    array(
                        'width' => 30,
                        'height' => 20,
                        'class' => 'md-secondary'
                    )
                );
                ?>
            </div>
            <div class="text" flex>
                <?= $sentence['text'] ?>
            </div>
            <md-button class="md-icon-button" href="<?= $sentenceUrl ?>">
                <md-icon>info</md-icon>
            </md-button>
        </div>
    </div>

    <? if (count($directTranslations) > 0) { ?>
        <div layout="column" class="direct translations">
            <md-divider></md-divider>
            <md-subheader><? __('Translations') ?></md-subheader>
            <? foreach ($directTranslations as $translation) {
                if ($numExtra > 1 && $displayedTranslations >= $maxDisplayed) {
                    $showExtra = 'ng-if="sentence.showExtra"';
                }
                $translationUrl = $html->url(array(
                    'controller' => 'sentences',
                    'action' => 'show',
                    $translation['id']
                ));
                ?>
                <div layout="row" layout-align="start center" <?= $showExtra ?>
                     class="translation">
                    <md-icon class="chevron">chevron_right</md-icon>
                    <div class="lang">
                        <?
                        echo $languages->icon(
                            $translation['lang'],
                            array(
                                'width' => 30,
                                'height' => 20,
                                'class' => 'md-secondary'
                            )
                        );
                        ?>
                    </div>
                    <div class="text" flex>
                        <?= $translation['text'] ?>
                    </div>
                    <md-button class="md-icon-button"
                               href="<?= $translationUrl ?>">
                        <md-icon>info</md-icon>
                    </md-button>
                </div>
                <?
                $displayedTranslations++;
            }
            ?>
        </div>
    <? } ?>

    <? if (count($indirectTranslations) > 0) {
        if ($numExtra > 1 && $displayedTranslations >= $maxDisplayed) {
            $showExtra = 'ng-if="sentence.showExtra"';
        }
        ?>
        <div layout="column" <?= $showExtra ?> class="indirect translations">
            <md-subheader><? __('Translations of translations') ?></md-subheader>
            <? foreach ($indirectTranslations as $translation) {
                if ($numExtra > 1 && $displayedTranslations >= $maxDisplayed) {
                    $showExtra = 'ng-if="sentence.showExtra"';
                }
                $translationUrl = $html->url(array(
                    'controller' => 'sentences',
                    'action' => 'show',
                    $translation['id']
                ));
                ?>
                <div layout="row" layout-align="start center" <?= $showExtra ?>
                     class="translation">
                    <md-icon class="chevron">chevron_right</md-icon>
                    <div class="lang">
                        <?
                        echo $languages->icon(
                            $translation['lang'],
                            array(
                                'width' => 30,
                                'height' => 20,
                                'class' => 'md-secondary'
                            )
                        );
                        ?>
                    </div>
                    <div class="text" flex>
                        <?= $translation['text'] ?>
                    </div>
                    <md-button class="md-icon-button"
                               href="<?= $translationUrl ?>">
                        <md-icon>info</md-icon>
                    </md-button>
                </div>
                <?
                $displayedTranslations++;
            } ?>
        </div>
    <? } ?>

    <? if ($numExtra > 1) { ?>
        <div layout="column">
            <md-button ng-click="sentence.showExtra = !sentence.showExtra">
                <md-icon ng-if="!sentence.showExtra">expand_more</md-icon>
                <span ng-if="!sentence.showExtra">
                    <?php
                    echo format(__n(
                        'Show 1 more translation',
                        'Show {number} more translations',
                        $numExtra,
                        true
                    ), array('number' => $numExtra))
                    ?>
                </span>
                <md-icon ng-if="sentence.showExtra">expand_less</md-icon>
                <span ng-if="sentence.showExtra">
                    <?php __('Fewer translations') ?>
                </span>
            </md-button>
        </div>
    <? } ?>
</div>
