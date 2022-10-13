The module integrates a Magento 2 based webstore with the **[Robokassa](https://www.robokassa.ru/en)** payment service (Russia).  
Robokassa is used by **[10% of Russian webstores](https://mage2.pro/t/3716)** (2017).  
The module is **free** and **open source**.

## Demo video
https://www.youtube.com/watch?v=hK3dBmW4tg4&list=PLTq8uOpBQGsFVidNBE9PO3G366IJ0JBTv

## [Screenshots](https://mage2.pro/tags/robokassa-screenshot)
- The frontend checkout screen:
    - [in the «**images**» mode](https://mage2.pro/t/topic/4536)
    - [in the «**text**» mode](https://mage2.pro/t/topic/4535)
- [The payment information blocks](https://mage2.pro/t/topic/4544)
- [The backend order list](https://mage2.pro/t/topic/4546)
- [The backend settings](https://mage2.pro/t/topic/4538)

## The available payment options for Russia
### e-wallet
- QIWI Wallet
- Yandex.Money
- WMR
- ElecsnetWallet
- RUR W1
### Internet Banking
- Bank Card
- Alfa-Click
- Russian Standard Bank
- VTB24
- RUR W1
-  Moscow Industrial Bank
-  Banca Intesa
-  Bank AVB
-  BINBANK
- Federal Bank For Innovation And Development
- Mezhtopenergobank
-  Sovcombank
-  National Bank TRUST
-  HandyBank
-  Bank Obrazovanie
-  FlexBank
-  FutureBank
-  KranBank
-  KostromaSelcombank
-  NS Bank
-  WestInterBank
-  Credit Ural Bank
### Bank card
-  Bank Card
-  Apple Pay
-  Samsung Pay
### terminal
-  QIWI Wallet
### mobile operator
-  Mts
-  Tele2
-  Tattelecom
-   Beeline
-  Megafon
### other methods
- Euroset
- Svyaznoy

### Электронным кошельком
 - QIWI Кошелек
 - Яндекс.Деньги
 -  WMR
 - Кошелек Элекснет
 -  RUR Единый кошелек
### Через интернет-банк
 -  Банковская карта
 -  Альфа-Клик
 -  Банк Русский Стандарт
 -  ВТБ24
 -  RUR Единый кошелек
 - Московский Индустриальный Банк
 -  Банк Интеза
 -  Банк АВБ
 -  БИНБАНК
 - ФБ Инноваций и Развития
 - Межтопэнергобанк
 - Совкомбанк
 - Национальный банк ТРАСТ
 - HandyBank
 -  Банк Образование
 - ФлексБанк
 - ФьючерБанк
 -  КранБанк
 - Костромаселькомбанк
 -  Независимый строительный банк
 - ВестИнтерБанк
 - Кредит Урал Банк
### Банковской картой
  -  Банковская карта
  -  Apple Pay
  -  Samsung Pay
### В терминале
  -  QIWI Кошелек
### Сотовые операторы
  -  МТС
  -  Tele2
  -  Таттелеком
  -  Билайн
  -  Мегафон
### Другие способы
  -   Евросеть
  -   Связной

## How to install
[Hire me in Upwork](https://www.upwork.com/fl/mage2pro), and I will: 
- install and configure the module properly on your website
- answer your questions
- solve compatiblity problems with third-party checkout, shipping, marketing modules
- implement new features you need

### 2. Self-installation
```
bin/magento maintenance:enable
rm -f composer.lock
composer clear-cache
composer require mage2pro/robokassa:*
bin/magento setup:upgrade
bin/magento cache:enable
rm -rf var/di var/generation generated/code
bin/magento setup:di:compile
rm -rf pub/static/*
bin/magento setup:static-content:deploy -f ru_RU en_US <additional locales, e.g.: kk_KZ>
bin/magento maintenance:disable
```

## How to update
```
bin/magento maintenance:enable
composer remove mage2pro/robokassa
rm -f composer.lock
composer clear-cache
composer require mage2pro/robokassa:*
bin/magento setup:upgrade
bin/magento cache:enable
rm -rf var/di var/generation generated/code
bin/magento setup:di:compile
rm -rf pub/static/*
bin/magento setup:static-content:deploy -f ru_RU en_US <additional locales, e.g.: kk_KZ>
bin/magento maintenance:disable
```