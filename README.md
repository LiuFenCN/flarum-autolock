# Flarum AutoLock

Automatically lock discussions after a configurable period of inactivity.

## Features

- **Auto-lock**: Locks discussions that have been inactive for N days
- **Hourly check**: Runs every hour via Flarum's scheduler
- **Configurable**: Set lock threshold (1-365 days) from admin panel
- **Smart filtering**: Optionally ignore sticky/already-locked discussions
- **Logging**: Logs how many discussions were locked each run
- **Flarum 2.0**: Built for Flarum 2.0 (rc.5+)

## Installation

```bash
composer require acolasialiuliu/flarum-autolock
```

## Usage

1. Go to **Admin → AutoLock** (in sidebar)
2. Enable AutoLock
3. Set the number of days of inactivity before auto-locking
4. Save

The system will automatically check every hour and lock eligible discussions.

## Settings

| Setting | Default | Description |
|---------|---------|-------------|
| Enabled | off | Master switch for auto-lock |
| Days | 30 | Days of inactivity before locking |
| Ignore Sticky | on | Don't lock pinned discussions |
| Ignore Locked | on | Skip already-locked discussions |

## License

MIT
