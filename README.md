# MailChimp Bundle for Symfony

## Configuration

Add your details to your `app/config/parameters.yml` file.  For example:
```yaml
    partfire_mailchimp_api_key: example-key-here
    partfire_mailchimp_list_id: example-list-id
```
Also add to your `app/AppKernel.php` file:

```php
    new PartFire\MailChimpBundle\PartFireMailChimpBundle()
```

## Example Usage

Use the service from the container: part_fire_mail_chimp.services.members