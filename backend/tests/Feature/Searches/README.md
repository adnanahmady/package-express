# Locations Finding Tests

You may ask why I separated the search concerns under `locations` path
instead of `partners`, will here is why.

## Short answer

Since the partner id can be any form of string and there is no control
on its form, it's better to separate searching services from partners
services, in this way the patterns will not conflict with each other
and we prevent future argument confusions.

## Long answer

In this system the partner can be get by its **id** like below.

    /api/v1/partners/1

but the **id** can be integer or any shape of string like below.

    /api/v1/partners/find

and if the search service gets added as above pattern, there is a big
possibility that a partner id be exactly like the path that is defined
for the search service.

just imaging that we added a service for searching in system related
to the partners, like `/api/v1/partners/nearest` and then suddenly a
partner with an id exactly like `nearest` is added to the system.
because we added our search service like `/api/v1/partners/nearest`
the partner can not see its own information by its id, and that's why
I have separated the search service completely from `partners` api.
Plus by categorizing paths under one unified root, we always know
where we should exactly search, and we will be able to categorize
all search algorithms of the system under one root.
