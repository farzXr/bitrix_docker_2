<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Список книг");

if (CModule::IncludeModule("iblock") && CModule::IncludeModule("catalog")) {
    $iblockId = 5; // Замените на ID вашего инфоблока книг

    $arSelect = ["ID", "NAME"]; // Убираем свойства цен
    $arFilter = ["IBLOCK_ID" => $iblockId, "ACTIVE" => "Y"];

    $res = CIBlockElement::GetList(
        ["SORT" => "ASC"], // Сортировка
        $arFilter,         // Условия фильтрации
        false,             // Группировка
        ["nPageSize" => 5], // Пагинация
        $arSelect          // Поля для выборки
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
            if ($price['CATALOG_GROUP_ID'] == 1) { // ID базовой цены
                $priceBase = $price['PRICE'];
            } elseif ($price['CATALOG_GROUP_ID'] == 2) { // ID дополнительной цены
                $priceSale = $price['PRICE'];
            }
        }

        // Рассчитываем итоговую цену
        $finalPrice = $priceSale !== null ? min($priceBase, $priceSale) : $priceBase;

        // Получение всех авторов книги
        $authors = [];
        $propertyRes = CIBlockElement::GetProperty(
            $iblockId,
            $arItem["ID"],
            [],
            ["CODE" => "AUTHORS"] // Получаем только свойство AUTHORS
        );

        while ($property = $propertyRes->Fetch()) {
            if ($property["VALUE"]) {
                // Запрос к инфоблоку авторов для получения имени
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
