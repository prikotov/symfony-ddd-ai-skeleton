# User Module DDD Example

`src/Module/User` is a neutral DDD/CQRS reference slice for this skeleton. It models a `UserProfile` record only.
It is not a production authentication subsystem.

## Safety boundaries

- No login, registration, RBAC, password, token, credential or default user flow is included.
- No secrets, external services or production endpoints are required.
- No migrations are generated or executed for this example.
- The default Infrastructure implementation is
  [`InMemoryUserProfileRepository`](../src/Module/User/Infrastructure/Repository/UserProfile/InMemoryUserProfileRepository.php),
  so a fresh skeleton does not create or mutate a production database by accident.

## Layer map

- Domain model and invariants:
  [`UserProfileModel`](../src/Module/User/Domain/Entity/UserProfileModel.php),
  [`DisplayNameVo`](../src/Module/User/Domain/ValueObject/DisplayNameVo.php),
  [`ContactEmailVo`](../src/Module/User/Domain/ValueObject/ContactEmailVo.php),
  [`UserProfileStatusEnum`](../src/Module/User/Domain/Enum/UserProfileStatusEnum.php).
- Domain repository contract and criteria:
  [`UserProfileRepositoryInterface`](../src/Module/User/Domain/Repository/UserProfile/UserProfileRepositoryInterface.php),
  [`UserProfileFindCriteria`](../src/Module/User/Domain/Repository/UserProfile/Criteria/UserProfileFindCriteria.php).
- Application query returning DTO:
  [`ListUserProfilesQuery`](../src/Module/User/Application/UseCase/Query/UserProfile/ListUserProfiles/ListUserProfilesQuery.php),
  [`ListUserProfilesQueryHandler`](../src/Module/User/Application/UseCase/Query/UserProfile/ListUserProfiles/ListUserProfilesQueryHandler.php).
- Module resource wiring:
  [`services.yaml`](../src/Module/User/Resource/config/services.yaml) and
  [`config/modules.php`](../config/modules.php).
  The web [`UserModule`](../apps/web/src/Module/User/UserModule.php) also exposes the module-local Twig namespace
  `WebUser` for templates under `apps/web/src/Module/User/Resource/templates` and the module-local translations path
  `apps/web/src/Module/User/Resource/translations`.
- Web Presentation security reference:
  [`UserProfileRoute`](../apps/web/src/Module/User/Route/UserProfileRoute.php),
  [`ActionEnum`](../apps/web/src/Module/User/Security/UserProfile/ActionEnum.php),
  [`PermissionEnum`](../apps/web/src/Module/User/Security/UserProfile/PermissionEnum.php),
  [`Rule`](../apps/web/src/Module/User/Security/UserProfile/Rule.php),
  [`Voter`](../apps/web/src/Module/User/Security/UserProfile/Voter.php),
  [`Grant`](../apps/web/src/Module/User/Security/UserProfile/Grant.php) and
  [`ListController`](../apps/web/src/Module/User/Controller/UserProfile/ListController.php).

## Persistence note

Projects generated from the skeleton may replace the in-memory repository alias with a Doctrine or other persistence
implementation. That replacement must stay in `Infrastructure`, keep the Domain repository contract unchanged, use an
explicit sort whitelist, and add migrations/tests in the concrete project branch.

## Integration bridge example

The User module also contains a small consumer-owned bridge to the Diagnostics module:

- User owns the Domain contract
  [`GetRuntimeDiagnosticsSnapshotServiceInterface`](../src/Module/User/Domain/Service/Integration/RuntimeDiagnostics/GetRuntimeDiagnosticsSnapshotServiceInterface.php)
  and scalar snapshot
  [`RuntimeDiagnosticsSnapshotDto`](../src/Module/User/Domain/Dto/RuntimeDiagnosticsSnapshotDto.php).
- The Integration implementation
  [`QueryBusGetRuntimeDiagnosticsSnapshotService`](../src/Module/User/Integration/Service/Diagnostics/QueryBusGetRuntimeDiagnosticsSnapshotService.php)
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
- `Voter` delegates the decision to `Rule`; controllers use `#[IsGranted]` and do not contain permission decision logic.
- `Grant` is a convenience wrapper for templates or other Presentation services that need to show or hide UI actions.
- The skeleton does not add login, registration, passwords, default users, `access_control`, object-level ACL or real
  firewall changes for this example.

Domain rules stay in `src/Module/User/Domain`: they protect model invariants such as profile data and lifecycle state.
Presentation security only decides whether the current request may reach a route/action. Projects built from the
skeleton should map `PermissionEnum` values to their own roles and users in project-specific security configuration.
