# Release Notes

## [Unreleased](https://github.com/laravel/vapor-ui/compare/v1.7.3...master)

## [v1.7.3](https://github.com/laravel/vapor-ui/compare/v1.7.2...v1.7.3) - 2023-03-23

- Updates job retry and delete to use dispatch_sync by @joedixon in https://github.com/laravel/vapor-ui/pull/90

## [v1.7.2](https://github.com/laravel/vapor-ui/compare/v1.7.1...v1.7.2) - 2023-02-16

- Removes `INIT_START` message by @nunomaduro in https://github.com/laravel/vapor-ui/pull/87

## [v1.7.1](https://github.com/laravel/vapor-ui/compare/v1.7.0...v1.7.1) - 2023-02-01

### Changed

- Add laravel-assets for publishing by @driesvints in https://github.com/laravel/vapor-ui/pull/83

### Fixed

- Fix queue name is displayed as array #84 by @mo7zayed in https://github.com/laravel/vapor-ui/pull/85
- Fix the queues key to be string not object by @mo7zayed in https://github.com/laravel/vapor-ui/pull/86

## [v1.7.0](https://github.com/laravel/vapor-ui/compare/v1.6.0...v1.7.0) - 2023-01-10

### Added

- Adds Laravel 10.x support by @nunomaduro in https://github.com/laravel/vapor-ui/pull/82

## [v1.6.0](https://github.com/laravel/vapor-ui/compare/v1.5.3...v1.6.0) - 2023-01-03

### Changed

- Uses PHP Native Type Declarations 🐘 by @nunomaduro in https://github.com/laravel/vapor-ui/pull/81

## [v1.5.3](https://github.com/laravel/vapor-ui/compare/v1.5.2...v1.5.3) - 2022-08-19

### Changed

- Support a custom manifest vapor file by @FelipeOAlbert in https://github.com/laravel/vapor-ui/pull/77

## [v1.5.2 (2022-02-08)](https://github.com/laravel/vapor-ui/compare/v1.5.1...v1.5.2)

### Changed

- Enable "font-display: swap " to avoid showing invisible text ([#67](https://github.com/laravel/vapor-ui/pull/67))

## [v1.5.1 (2022-01-18)](https://github.com/laravel/vapor-ui/compare/v1.5.0...v1.5.1)

### Fixed

- Remove Preparing to boot Octane message ([#66](https://github.com/laravel/vapor-ui/pull/66))

## [v1.5.0 (2022-01-12)](https://github.com/laravel/vapor-ui/compare/v1.4.0...v1.5.0)

### Changed

- Laravel 9 support ([#65](https://github.com/laravel/vapor-ui/pull/65))

## [v1.4.0 (2021-11-16)](https://github.com/laravel/vapor-ui/compare/v1.3.0...v1.4.0)

### Added

- Add flexible route configuration ([#63](https://github.com/laravel/vapor-ui/pull/63))

## [v1.3.0 (2021-10-13)](https://github.com/laravel/vapor-ui/compare/v1.2.0...v1.3.0)

### Added

- PHP 8.1 support ([#60](https://github.com/laravel/vapor-ui/pull/60))

## [v1.2.0 (2021-07-06)](https://github.com/laravel/vapor-ui/compare/v1.1.2...v1.2.0)

### Added

- Custom queue monitoring ([#58](https://github.com/laravel/vapor-ui/pull/58), [78b606b](https://github.com/laravel/vapor-ui/commit/78b606be2dd45d2a393591d5d2c0fa170a00c484))

## [v1.1.2 (2021-06-15)](https://github.com/laravel/vapor-ui/compare/v1.1.1...v1.1.2)

### Fixed

- Logs/Show link should be a <a>, not a <button> ([#55](https://github.com/laravel/vapor-ui/pull/55))

## [v1.1.1 (2021-06-01)](https://github.com/laravel/vapor-ui/compare/v1.1.0...v1.1.1)

### Fixed

- Add symfony/yaml ([7d77dd4](https://github.com/laravel/vapor-ui/commit/7d77dd4cf08f2952eab22468c2d49ae164c67a13))

## [v1.1.0 (2021-06-01)](https://github.com/laravel/vapor-ui/compare/v1.0.3...v1.1.0)

### Added

- Support for multiple queues ([#50](https://github.com/laravel/vapor-ui/pull/50))

## [v1.0.3 (2021-01-11)](https://github.com/laravel/vapor-ui/compare/v1.0.2...v1.0.3)

### Fixed

- Ignores Vapor internal message from logs tab ([7c5a8e4](https://github.com/laravel/vapor-ui/commit/7c5a8e42014099f9ba70c3f99e0905141dd311df))

## [v1.0.2 (2021-01-05)](https://github.com/laravel/vapor-ui/compare/v1.0.1...v1.0.2)

### Changed

- Supports environments that switched to docker runtime ([#42](https://github.com/laravel/vapor-ui/pull/42))

## [v1.0.1 (2020-12-22)](https://github.com/laravel/vapor-ui/compare/v1.0.0...v1.0.1)

### Fixed

- Retrying failed jobs with retryUntil ([#39](https://github.com/laravel/vapor-ui/pull/39))

## [v1.0.0 (2020-11-03)](https://github.com/laravel/vapor-ui/compare/v0.0.12...v1.0.0)

### Fixed

- Endless searching for non-existing entries ([#33](https://github.com/laravel/vapor-ui/pull/33))

## [v0.0.12 (2020-10-30)](https://github.com/laravel/vapor-ui/compare/v0.0.11...v0.0.12)

### Added

- Support for PHP 8 ([#29](https://github.com/laravel/vapor-ui/pull/29))

## [v0.0.11 (2020-10-22)](https://github.com/laravel/vapor-ui/compare/v0.0.10...v0.0.11)

### Added

- Support for log records "output" key ([#30](https://github.com/laravel/vapor-ui/pull/30))

## [v0.0.10 (2020-09-24)](https://github.com/laravel/vapor-ui/compare/v0.0.9...v0.0.10)

### Added

- Customizable Middleware stack ([#23](https://github.com/laravel/vapor-ui/pull/23))

## [v0.0.9 (2020-09-22)](https://github.com/laravel/vapor-ui/compare/v0.0.8...v0.0.9)

### Fixed

- Wrong serialization of date objects while using CloudWatch API ([#21](https://github.com/laravel/vapor-ui/pull/21))

## [v0.0.8 (2020-09-18)](https://github.com/laravel/vapor-ui/compare/v0.0.7...v0.0.8)

### Fixed

- Usage of dashboard with different backend timezone config ([3d7d269](https://github.com/laravel/vapor-ui/commit/3d7d269aa985e92480f0999ff4b91aff190926e0))

## [v0.0.7 (2020-09-18)](https://github.com/laravel/vapor-ui/compare/v0.0.6...v0.0.7)

### Changed

- Removes "testing" environment from authorized environments by default ([482f23c](https://github.com/laravel/vapor-ui/commit/482f23c6ad5605cd4a247e148948998ed5c2b02b))

## [v0.0.6 (2020-09-14)](https://github.com/laravel/vapor-ui/compare/v0.0.5...v0.0.6)

### Added

- Jobs metrics tab ([18c0ab4](https://github.com/laravel/vapor-ui/commit/18c0ab4944adae359d0428da6a5f4b3219121453), [58547b5](https://github.com/laravel/vapor-ui/commit/58547b5e766ac6c1a1a6d5aeb78b1ca619a90088))

### Changed

- Message on missing environment variables ([160c68b](https://github.com/laravel/vapor-ui/commit/160c68bd683c4edcf56a7699e69bb745afbbb0af))

## [v0.0.5 (2020-09-03)](https://github.com/laravel/vapor-ui/compare/v0.0.4...v0.0.5)

### Added

- Improved troubleshooting messages on "Server Error" ([c27cbed](https://github.com/laravel/vapor-ui/commit/c27cbedcc300fdf5d0b26f895f7736c25929a21f))

## [v0.0.4 (2020-09-03)](https://github.com/laravel/vapor-ui/compare/v0.0.3...v0.0.4)

### Fixed

- Typo on "still searching" text ([2e88395](https://github.com/laravel/vapor-ui/commit/2e88395378163636fab171289e2b1fa400a4dae4))
- Truncates exception classe names ([e592f44](https://github.com/laravel/vapor-ui/commit/e592f44ee9c13af4032fe347f196d9a9cc5d0782))

## [v0.0.3 (2020-09-03)](https://github.com/laravel/vapor-ui/compare/v0.0.2...v0.0.3)

### Fixed

- Carbon parsing unexpected date formats ([89c4581](https://github.com/laravel/vapor-ui/commit/89c4581f5ab897bf7965cc29b26bb2e389985bed))

## [v0.0.2 (2020-09-03)](https://github.com/laravel/vapor-ui/compare/v0.0.1...v0.0.2)

### Fixed

- Missing `web` middleware ([10cc37b](https://github.com/laravel/vapor-ui/commit/10cc37ba070fe3f0e44ce973cad5abf72786c694))

## v0.0.1 (2020-09-02)

Initial release
