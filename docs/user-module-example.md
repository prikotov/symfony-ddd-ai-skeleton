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

## Persistence note

Projects generated from the skeleton may replace the in-memory repository alias with a Doctrine or other persistence
implementation. That replacement must stay in `Infrastructure`, keep the Domain repository contract unchanged, use an
explicit sort whitelist, and add migrations/tests in the concrete project branch.
