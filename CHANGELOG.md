# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased][unreleased]
### Added
- Travis configuration
- Gruntfile.js to run all inspections
- This CHANGELOG

### Changed
- "ObjectAccess" and "Navigation" namespaces instead of "Common"
- Documentation reflects new namespaces
- SerializerFacade and AbstractFactory instead of SerializerFactory
- LICENSE in Markdown format
- README with icons
- Use PSR-4 to remove subfolders in `spec/` and `src/`

### Fixed
- Code adheres to phpcs and phpmd

## [0.1.0] - 2015-06-25
### Added
- Behat features and phpspec specs
- SerializerFactory
- Serializer and Deserializer for JSON, URL and XML
- TypeProvider that uses DocBlock var tags

[unreleased]: https://github.com/scato/serializer/compare/v0.1.0...HEAD
[0.1.0]: https://github.com/scato/serializer/tree/v0.1.0
