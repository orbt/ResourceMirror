Resource Mirror
===============

Resource Mirror is a library for mirroring webpage resources in a local directory for serving over the web as a mirror.
This library uses the Symfony Event Dispatcher to dispatch resource events for registered event listeners to perform
further actions, e.g. on resources that have just been materialized.

This library contains these main components:

* `ResourceMirror`: Main handler for materializing resources given a path on a specified base URL.
* `Resource`: Interface for accessing resources and maintaining metadata about resources for the mirror to use.
* `GenericResource`: Base resource type. A generic resource can resolve another relative path based on itself.
* `Materialized`: Interface for accessing resource content. A `MaterializedResource` can be constructed around a
  `Resource` once it has been materialized and is accessible.
* `ResourceCollection`: A collection of resources. Some utilities can accept a collection of resources and produce a new
  collection with completely different resources (e.g. by aggregating them).
* `ResourceEvent`: Event dispatched containing a resource collection.

Installation using Composer
---------------------------

Add the following to the `"require"` list in your `composer.json` file:

```
    "orbt/resource-mirror": "dev-master"
```

Run composer to update dependencies:

```bash
$ composer update
```

Or to just download this library:

```bash
$ composer update orbt/resource-mirror
```

License
-------

This library is licensed under the MIT License. Full license terms are available in the included LICENSE file.
