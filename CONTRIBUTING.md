# Contributing

Contributions are **welcome** and will be fully **credited**.

We accept contributions via Pull Requests on [Github](https://github.com/scato/serializer).


## Documentation

The [doc](doc/) folder contains documentation on the internal API. This is a good place to start if you want to contribute to this project, or if you want to write your own extensions.


## Pull Requests

- **[PSR-2 Coding Standard](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)** - Implement PSR-2, including DocBlocks.

- **[PHPMD Rulesets](http://phpmd.org/rules/index.html)** - Implement all but the "Clean Code Rules".

- **Test first!** - Your patch won't be accepted if it doesn't have specs, and a feature file if applicable.

- **Document any change in behaviour** - Make sure the `README.md` and any other relevant documentation are kept up-to-date.

- **Consider our release cycle** - We try to follow [SemVer v2.0.0](http://semver.org/). Randomly breaking public APIs is not an option.

- **Create feature branches** - Don't ask us to pull from your master branch.

- **One pull request per feature** - If you want to do more than one thing, send multiple pull requests.


## Running Tests

``` bash
$ composer test
```

You can also run:

``` bash
$ grunt watch
```

This will run all tests automatically every time you change a file.

**Happy coding**!
