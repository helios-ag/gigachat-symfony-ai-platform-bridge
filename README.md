# GigaChat Symfony AI Platform Bridge

A Symfony bundle for integrating the GigaChat AI platform into your Symfony applications.

## Overview

This package serves as a bridge between your Symfony-based PHP application and the [GigaChat](https://giga.chat/) AI platform—a powerful Russian language-focused large language model based on Mixture of Experts (MoE) architecture. With this bridge, you can seamlessly connect your app to GigaChat's APIs, leveraging advanced natural language processing capabilities for chatbots, content generation, support, and more.

## Features

- Easy integration with Symfony applications
- Service container configuration for GigaChat API credentials
- Built-in support for authentication and secure API calls
- Helper services for sending prompts and handling responses
- MIT License

## Requirements

- PHP (version compatible with Symfony 5 or 6)
- Symfony Framework
- GigaChat API credentials (Client ID, Secret, Scope)

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

Register and configure the bundle in your `config/bundles.php` and `config/packages/gigachat_bridge.yaml` as appropriate.

## Usage Example

Inject the GigaChat client service into your controller or service and use it to send prompts:

```php
// Example Symfony service usage (pseudo-code)
$gigachatClient = $container->get(GigaChat\Client::class);
$response = $gigachatClient->sendPrompt('Привет, расскажи о себе!');
echo $response->getText();
```

## About GigaChat

GigaChat is a large Russian-language model developed with Mixture of Experts architecture (GPT-3, 13B parameters). It is designed for efficient language modeling and powers chatbots, content assistants, and more. More information: [arXiv paper](https://doi.org/10.48550/arXiv.2506.09440).

## License

MIT License. See [LICENSE](LICENSE) for details.

## Links

- [GigaChat Official Site](https://giga.chat/)
- [Symfony](https://symfony.com/)
- [Repository](https://github.com/helios-ag/gigachat-symfony-ai-platform-bridge)

---

> _Note: This README was generated based on available repository metadata and typical usage for Symfony bridges. Please update with specific details and code examples from your implementation as needed._