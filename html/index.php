<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Список книг");

if (CModule::IncludeModule("iblock") && CModule::IncludeModule("catalog")) {
    $iblockId = 5;

    $arSelect = ["ID", "NAME"];
    $arFilter = ["IBLOCK_ID" => $iblockId, "ACTIVE" => "Y"];

    $res = CIBlockElement::GetList(
        ["SORT" => "ASC"],
        $arFilter,
        false,
        ["nPageSize" => 5],
        $arSelect
    );

    while ($arItem = $res->GetNext()) {
        // Получение цен товара
        $priceBase = null;
        $priceSale = null;

        $priceRes = \Bitrix\Catalog\PriceTable::getList([
            'filter' => ['=PRODUCT_ID' => $arItem['ID']],
            'select' => ['CATALOG_GROUP_ID', 'PRICE', 'CURRENCY']
        ]);

        while ($price = $priceRes->fetch()) {
            if ($price['CATALOG_GROUP_ID'] == 1) {
                $priceBase = $price['PRICE'];
            } elseif ($price['CATALOG_GROUP_ID'] == 2) {
                $priceSale = $price['PRICE'];
            }
        }


        $finalPrice = $priceSale !== null ? min($priceBase, $priceSale) : $priceBase;


        $authors = [];
        $propertyRes = CIBlockElement::GetProperty(
            $iblockId,
            $arItem["ID"],
            [],
            ["CODE" => "AUTHORS"]
        );

        while ($property = $propertyRes->Fetch()) {
            if ($property["VALUE"]) {

                $authorRes = CIBlockElement::GetList(
                    [],
                    ["ID" => $property["VALUE"]],
                    false,
                    false,
                    ["ID", "NAME"]
                );
                if ($author = $authorRes->GetNext()) {
                    $authors[] = $author["NAME"];
                }
            }
        }

        ?>
        <div class="container">
            <div class="book">
                <div class="book-title"><?= htmlspecialchars($arItem["NAME"]) ?></div>
                <div class="authors"><?= htmlspecialchars(implode(", ", $authors)) ?> </div>
                <div class="price"><?= htmlspecialchars($finalPrice) ?>₽</div>
            </div>
        </div>
        <?php
    }
    ?>

    <?php
} else {
    echo "Ошибка подключения модулей.";
}

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>
