# Hyvä Linked Product – Magento 2 Extension

A Magento 2 module for Hyvä themes that links products sharing similar styles but differing in attributes such as size, color, or material. This improves product organization and enhances the shopping experience.

---

## 📌 Features

* Link similar products by attributes (e.g., color, size, material).
* Display linked products on product listing and product view pages.
* Easy to configure backend settings.

---

## ⚙️ Configuration

Currently, there are no additional configuration options beyond enabling the module. The module works automatically with linked products.

---

## 📦 Installation

### Install via Composer

1. Require the module:

```bash
composer require sutunam/hyva-linked-product
```

2. Enable and upgrade the module:

```bash
bin/magento module:enable Sutunam_HyvaLinkedProduct
bin/magento setup:upgrade
bin/magento cache:flush
```

3. For production mode:

```bash
bin/magento setup:di:compile
bin/magento setup:static-content:deploy -f
```

---

## 📝 Changelog

### 1.0.3

* Remove .gitlab-ci.yml to use the same one as other modules
* Update license

### 1.0.2

* Update Readme.md

### 1.0.1

* Updated required modules.

### 1.0.0

* Initial module release.

---

## ✔️ Notes

* Fully compatible with Hyvä theme.
* No additional configuration is needed for basic usage.
* Designed to improve product discoverability and enhance the shopping experience.

## Development by Sutunam

We are an Open Source Software Development Company, specialized in Magento 2 and [Hyva Silver Partner](https://en.sutunam.vn/solutions/hyva-specialists-magento-experts/)

[Contact us](https://en.sutunam.vn/contact/)
