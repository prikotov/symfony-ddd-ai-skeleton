# Diagnostics Query Flow Reference

The bundled `Diagnostics` module is the canonical minimal read-only Query flow in this skeleton.
It demonstrates how a Presentation entrypoint calls Application through `QueryBusComponentInterface`
without pulling Domain or Infrastructure dependencies into controllers or console commands.

## Flow

1. Web Presentation calls `QueryBusComponentInterface` from
   [`CheckController`](../apps/web/src/Module/Diagnostics/Controller/Health/CheckController.php)
   and sends `GetRuntimeDiagnosticsQuery`.
2. Console Presentation follows the same Application boundary in
   [`CheckCommand`](../apps/console/src/Module/Diagnostics/Command/Runtime/CheckCommand.php).
3. Application receives [`GetRuntimeDiagnosticsQuery`](../src/Module/Diagnostics/Application/UseCase/Query/GetRuntimeDiagnostics/GetRuntimeDiagnosticsQuery.php)
   and returns [`RuntimeDiagnosticsDto`](../src/Module/Diagnostics/Application/Dto/RuntimeDiagnosticsDto.php)
   from [`GetRuntimeDiagnosticsQueryHandler`](../src/Module/Diagnostics/Application/UseCase/Query/GetRuntimeDiagnostics/GetRuntimeDiagnosticsQueryHandler.php).
4. Domain defines only the local runtime context contract and value object; Infrastructure reads that context from the kernel.

## Boundaries

- Keep `/health` read-only, dependency-light and safe for unauthenticated liveness checks.
- Do not add auth, database writes, external probes, secrets or business-domain vocabulary to this module.
- If a project needs readiness or subsystem checks, add a separate project-specific query instead of expanding this skeleton example.

## Tests

- Unit coverage: [`GetRuntimeDiagnosticsQueryHandlerTest`](../tests/Unit/Module/Diagnostics/Application/UseCase/Query/GetRuntimeDiagnostics/GetRuntimeDiagnosticsQueryHandlerTest.php).
- Web integration coverage: [`CheckControllerTest`](../apps/web/tests/Integration/Module/Diagnostics/Controller/Health/CheckControllerTest.php).
- Console integration coverage: [`CheckCommandTest`](../apps/console/tests/Integration/Module/Diagnostics/Command/Runtime/CheckCommandTest.php).
