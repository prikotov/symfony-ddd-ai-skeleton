# UI reference

`docs/ui/vendor-theme/` — локальная копия купленной UI-темы из проекта TasK.

Рекомендуемый CSS-фреймворк: **Bootstrap 5**.

Установка через AssetMapper (без Node.js):

```bash
cd apps/web
php bin/console importmap:require bootstrap/css/bootstrap.min.css bootstrap/js/bootstrap.bundle.min.js
```

Правила использования:

* директория `docs/ui/vendor-theme/` добавлена в `.gitignore` и не должна попадать в Git;
* тема используется только как документация/reference: HTML-примеры, investment dashboard, визуальные паттерны и варианты компонентов;
* runtime-код `symfony-ddd-ai-skeleton` не должен ссылаться на файлы из `docs/ui/vendor-theme/`;
* нужные элементы интерфейса переносим в tracked Twig components/templates/assets `apps/web`;
* при переносе кода из TasK адаптируем namespace, доменные зависимости и тексты под `symfony-ddd-ai-skeleton`.

Источник локальной копии:

```text
/home/dp/MyProjects/TasK/Development/docs/theme
```

Текущая локальная копия:

```text
docs/ui/vendor-theme/
```
