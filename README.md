# GigaChat Symfony AI Platform Bridge

This is library that provides a bridge between your Symfony-based PHP application and the [GigaChat](https://developers.sber.ru/docs/ru/gigachat/api/main) AI platform.

## Features

- Easy integration with Symfony or any other modern PHP applications
- Service container configuration for GigaChat API credentials
- Built-in support for authentication and secure API calls
- Helper services for sending prompts and handling responses
- MIT License

## Requirements

- At least PHP 8.2
- GigaChat API credentials (Client ID, Client Secret, Scope)

## Installation

```bash
composer require helios-ag/gigachat-symfony-ai-platform-bridge
```

## Configuration

Add your GigaChat credentials to your Symfony environment variables (`.env`):

```dotenv
GIGACHAT_CLIENT_ID=your_client_id
GIGACHAT_CLIENT_SECRET=your_client_secret
GIGACHAT_CLIENT_SCOPE=your_scope
```

## Usage Example

Check the [example](/example) directory for more details.

## About GigaChat

https://developers.sber.ru/docs/ru/gigachat/api/main

## License

MIT License. See [LICENSE](LICENSE) for details.

## Links

- [GigaChat API Docs](https://developers.sber.ru/docs/ru/gigachat/api/main)
- [Symfony](https://symfony.com/)
- [Repository](https://github.com/helios-ag/gigachat-symfony-ai-platform-bridge)

---