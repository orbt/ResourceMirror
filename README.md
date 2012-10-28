Resource Mirror
===============

Resource Mirror is a library for mirroring webpage resources in a local directory for serving over the web as a mirror.
This library uses the Symfony Event Dispatcher to dispatch resource events for registered event listeners to perform
further actions, e.g. on resources that have just been materialized.

This library contains these main components:

* `ResourceMirror`: Main handler for materializing resources given a path on a specified base URL.
* `Resource`: Interface for accessing resources and maintaining metadata about resources in order for the mirror to use
  them. This interface has these variants:
  * `UrlResource`: Indicating a resource with a path relative to a base URL in a `ResourceMirror`.
  * `UnmaterializedResource`: Indicating a resource has a relative URL but has not been materialized.
* `ResourceCollection`: A collection of resources. Some utilities can accept a collection of resources and produce a new
  collection with completely different resources (e.g. by aggregating them).
* `ResourceEvent`: Event dispatched containing a resource collection.

License
-------

This library is licensed under the MIT License. Full license terms are available in the included LICENSE file.
