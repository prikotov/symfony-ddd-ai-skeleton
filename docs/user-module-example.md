# User Module DDD Example

`src/Module/User` is a neutral DDD/CQRS reference slice for this skeleton. It models a `UserProfile` record only.
It is not a production authentication subsystem.

## Safety boundaries

- No login, registration, RBAC, password, token, credential or default user flow is included.
- No secrets, external services or production endpoints are required.
- No migrations are executed by the skeleton example. Generate and review a project-specific migration before using the
  Doctrine table in a concrete project.
- The default Infrastructure implementation is Doctrine-backed, but it persists only neutral profile data: no passwords,
  default users, credentials or auth flows.

## Layer map

- Domain model and invariants:
  [`UserProfileModel`](../src/Module/User/Domain/Entity/UserProfileModel.php),
  [`DisplayNameVo`](../src/Module/User/Domain/ValueObject/DisplayNameVo.php),
  [`ContactEmailVo`](../src/Module/User/Domain/ValueObject/ContactEmailVo.php),
  [`UserProfileStatusEnum`](../src/Module/User/Domain/Enum/UserProfileStatusEnum.php).
  `UserProfileModel` is a Doctrine entity with explicit module mapping via
  [`UserModule`](../src/Module/User/UserModule.php) and reusable technical fields from
  [`IdTrait`](../src/Component/Doctrine/Trait/IdTrait.php),
  [`UuidTrait`](../src/Component/Doctrine/Trait/UuidTrait.php) and
  [`InsTsTrait`](../src/Component/Doctrine/Trait/InsTsTrait.php).
- Domain repository contract and criteria:
  [`UserProfileRepositoryInterface`](../src/Module/User/Domain/Repository/UserProfile/UserProfileRepositoryInterface.php),
  [`UserProfileFindCriteria`](../src/Module/User/Domain/Repository/UserProfile/Criteria/UserProfileFindCriteria.php).
- Infrastructure persistence:
  [`UserProfileRepository`](../src/Module/User/Infrastructure/Repository/UserProfile/UserProfileRepository.php),
  [`CriteriaMapper`](../src/Module/User/Infrastructure/Repository/UserProfile/Criteria/CriteriaMapper.php) and
  [`UserProfileFindCriteriaMapper`](../src/Module/User/Infrastructure/Repository/UserProfile/Criteria/Mapper/UserProfileFindCriteriaMapper.php).
  The dispatcher resolves Domain criteria by runtime type, while concrete mappers apply criteria to Doctrine QueryBuilder,
  keep sort fields whitelisted and reuse generic limit/offset/sort primitives.
- Application query returning DTO:
  [`ListUserProfilesQuery`](../src/Module/User/Application/UseCase/Query/UserProfile/ListUserProfiles/ListUserProfilesQuery.php),
  [`ListUserProfilesQueryHandler`](../src/Module/User/Application/UseCase/Query/UserProfile/ListUserProfiles/ListUserProfilesQueryHandler.php).
- Module resource wiring:
  [`services.yaml`](../src/Module/User/Resource/config/services.yaml) and
  [`config/modules.php`](../config/modules.php).
  The web [`UserModule`](../apps/web/src/Module/User/UserModule.php) also exposes the module-local Twig namespace
  `web.user` for templates under `apps/web/src/Module/User/Resource/templates` and the module-local translations path
  `apps/web/src/Module/User/Resource/translations`.
- Web Presentation security reference:
  [`UserProfileRoute`](../apps/web/src/Module/User/Route/UserProfileRoute.php),
  [`list.html.twig`](../apps/web/src/Module/User/Resource/templates/user_profile/list.html.twig),
  [`ActionEnum`](../apps/web/src/Module/User/Security/UserProfile/ActionEnum.php),
  [`PermissionEnum`](../apps/web/src/Module/User/Security/UserProfile/PermissionEnum.php),
  [`Rule`](../apps/web/src/Module/User/Security/UserProfile/Rule.php),
  [`Voter`](../apps/web/src/Module/User/Security/UserProfile/Voter.php),
  [`Grant`](../apps/web/src/Module/User/Security/UserProfile/Grant.php) and
  [`ListController`](../apps/web/src/Module/User/Controller/UserProfile/ListController.php).

## Persistence note

The User module demonstrates the default persistence-oriented module shape:

- Doctrine mapping is explicit through `DoctrineInterface`; global `auto_mapping: true` is not used as a module contract.
- The entity remains in `Domain/Entity`, while QueryBuilder and database criteria mapping stay in `Infrastructure`.
- Reusable Doctrine primitives (`id`, `uuid`, `ins_ts`) live in `src/Component/Doctrine/*`; module-specific fields stay
  inside the entity.
- Creation timestamps should come from `Psr\Clock\ClockInterface` in the factory/use case that creates the entity; the
  entity itself does not call a static `ClockFactory` or the service container.
- The Domain repository contract and criteria do not depend on Doctrine.
- Sort fields are whitelisted in Infrastructure before they reach Doctrine.
- The example does not wrap searchable columns in `LOWER(...)`; case-insensitive search is a database/platform concern
  (for example collation, `citext`, functional index or project-specific query strategy).
- The repository calls `persist()` but does not flush; transaction boundaries stay in Application command handlers.
- A concrete project must generate/review its own migration for the target database platform before relying on the table.

## Integration bridge example

The User module also contains a small consumer-owned bridge to the Diagnostics module:

- User owns the Domain contract
  [`GetRuntimeDiagnosticsSnapshotServiceInterface`](../src/Module/User/Domain/Service/RuntimeDiagnostics/GetRuntimeDiagnosticsSnapshotServiceInterface.php)
  and scalar snapshot
  [`RuntimeDiagnosticsSnapshotDto`](../src/Module/User/Domain/Dto/RuntimeDiagnosticsSnapshotDto.php).
- The Integration implementation
  [`GetRuntimeDiagnosticsSnapshotService`](../src/Module/User/Integration/Service/RuntimeDiagnostics/GetRuntimeDiagnosticsSnapshotService.php)
  calls the Diagnostics Application query
  [`GetRuntimeDiagnosticsQuery`](../src/Module/Diagnostics/Application/UseCase/Query/GetRuntimeDiagnostics/GetRuntimeDiagnosticsQuery.php)
  through `QueryBusComponentInterface` and maps
  [`RuntimeDiagnosticsDto`](../src/Module/Diagnostics/Application/Dto/RuntimeDiagnosticsDto.php)
  into the User-owned snapshot.
- Dependency direction stays one-way: `User Domain contract <- User Integration service -> Diagnostics Application`.
  The bridge does not depend on Diagnostics Domain or Infrastructure models.
- The DI alias is declared in
  [`services.yaml`](../src/Module/User/Resource/config/services.yaml), so consumers depend on the User-owned interface.

## Presentation security boundary

The web User module shows a small route/action/permission/grant/rule/voter pattern for Presentation access checks only.
It is not a production authentication or RBAC subsystem:

- `ActionEnum` is the controller-level operation (`user.user_profile.list`).
- `PermissionEnum` is the permission checked by the Presentation `Rule`.
- `ListController` renders the module-local Twig template `@web.user/user_profile/list.html.twig`; it does not return
  JSON and does not contain business logic.
- `Voter` delegates the decision to `Rule`; controllers use `#[IsGranted]` and do not contain permission decision logic.
- `Grant` is a convenience wrapper for templates or other Presentation services that need to show or hide UI actions.
- The skeleton does not add login, registration, passwords, default users, `access_control`, object-level ACL or real
  firewall changes for this example.

Domain rules stay in `src/Module/User/Domain`: they protect model invariants such as profile data and lifecycle state.
Presentation security only decides whether the current request may reach a route/action. Projects built from the
skeleton should map `PermissionEnum` values to their own roles and users in project-specific security configuration.
