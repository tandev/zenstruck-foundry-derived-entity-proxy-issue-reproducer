# zenstruck-foundry-derived-entity-proxy-issue-reproducer

**FIXED IN https://github.com/zenstruck/foundry/issues/1056**

We have two Entities `OwningSide` and `InverseSide` where `InverseSide` has derived identity

The test fails with 

```
Doctrine\ORM\ORMInvalidArgumentException: Binding entities to query parameters only allowed for entities that have an identifier.
Class "App\Entity\OwningSide" does not have an identifier.
```

for the autorefresh mechanism
