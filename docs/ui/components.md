# UI components

Компоненты `apps/web` строятся на **Bootstrap 5** и Phoenix theme patterns из TasK.

Перенесённые базовые Twig components:

* `Phoenix:Alert`
* `Phoenix:Badge`
* `Phoenix:DropdownActions`
* `Phoenix:ExternalLink`
* `Phoenix:Flash`
* `Phoenix:ImportantAlert`
* `Phoenix:NavLink`
* `Phoenix:NavList`
* `Phoenix:NavListItem`
* `Phoenix:Pagination`
* `Phoenix:Sort`
* `Phoenix:Spinner`
* `Phoenix:Tooltip`

Пагинация:

* `Skeleton\Web\Component\Pagination\PaginationRequestDto`
* `Skeleton\Web\Component\Pagination\PaginationRequestToApplicationDtoMapper`
* `Skeleton\Common\Application\Dto\PaginationDto`

Проект русский-only, поэтому базовые компоненты используют русские UI-тексты напрямую, без обязательного слоя переводов.

Не переносить без адаптации:

* компоненты с доменными зависимостями TasK (`Billing`, `Project`, `Source`, `Team`, `User` и т.п.);
* прямые ссылки на assets из `docs/ui/vendor-theme/`;
* HTML из купленной темы как runtime template без очистки и адаптации.
