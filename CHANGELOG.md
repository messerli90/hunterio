# Changelog

All notable changes to `hunterio` will be documented in this file

## 1.0.0 - 2020-05-24

- initial release

## 1.0.1 - 2020-05-27

- FIX: account() endpoint throwing auth error

## 1.1.0 - 2020-06-09

- Add shortcut assuming 'domain' is used for argument for:
  - `Hunter::domainSearch($domain = null)`
  - `Hunter::emailFinder($domain = null)`
  - `Hunter::emailCount($domain = null`
- Deprecate
  - `Hunter::emailVerifier()->verify($email)`
  - and replace with
  - `Hunter::verifyEmail($email);`
