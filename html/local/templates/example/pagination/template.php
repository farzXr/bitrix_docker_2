<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if ($arResult["NavPageCount"] > 1): ?>
    <div class="pagination">
        <?php if ($arResult["NavPageNomer"] > 1): ?>
            <a class="page-link prev" href="<?= $arResult["sUrlPath"] . '?' . $arResult["NavQueryString"] . 'PAGEN_' . $arResult["NavNum"] . '=' . ($arResult["NavPageNomer"] - 1) ?>">«</a>
        <?php endif; ?>

        <?php for ($page = 1; $page <= $arResult["NavPageCount"]; $page++): ?>
            <?php if ($page == $arResult["NavPageNomer"]): ?>
                <span class="page-link active"><?= $page ?></span>
            <?php else: ?>
                <a class="page-link" href="<?= $arResult["sUrlPath"] . '?' . $arResult["NavQueryString"] . 'PAGEN_' . $arResult["NavNum"] . '=' . $page ?>"><?= $page ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]): ?>
            <a class="page-link next" href="<?= $arResult["sUrlPath"] . '?' . $arResult["NavQueryString"] . 'PAGEN_' . $arResult["NavNum"] . '=' . ($arResult["NavPageNomer"] + 1) ?>">»</a>
        <?php endif; ?>
    </div>
<?php endif; ?>
