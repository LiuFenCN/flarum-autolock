# Flarum AutoLock

讨论不活跃一段时间后**自动锁定**。
**Automatically locks discussions** after a configurable period of inactivity.

基于 Flarum 调度器每小时巡检一次，把超过设定天数没有新回复的讨论自动上锁，省去手动维护旧帖的麻烦。为 Flarum 2.0（rc.5+）构建。

An hourly sweep on Flarum's scheduler locks discussions that have seen no new replies for more than the configured number of days, so old threads maintain themselves. Built for Flarum 2.0 (rc.5+).

## 功能特性 · Features

- **自动锁定（Auto-lock）**：锁定 N 天不活跃的讨论 · locks discussions inactive for N days
- **每小时巡检（Hourly check）**：通过 Flarum 调度器每小时运行一次 · runs every hour via Flarum's scheduler
- **可配置（Configurable）**：锁定阈值 1–365 天，后台可调 · lock threshold (1–365 days) settable from the admin panel
- **智能过滤（Smart filtering）**：可选择忽略置顶 / 已锁定讨论 · optionally ignore sticky / already-locked discussions
- **日志（Logging）**：记录每次运行锁定了多少讨论 · logs how many discussions were locked each run
- **Flarum 2.0**：为 Flarum 2.0（rc.5+）构建 · built for Flarum 2.0 (rc.5+)

## 安装 · Installation

```bash
composer require acolasialiuliu/flarum-autolock
```

然后在后台启用，或执行：
Then enable it in the admin panel, or run:

```bash
php flarum extension:enable acolasialiuliu-autolock
php flarum cache:clear
```

## 使用 · Usage

1. 进入 **后台 → AutoLock**（侧边栏）
2. 开启 AutoLock
3. 设置不活跃多少天后自动锁定
4. 保存

1. Go to **Admin → AutoLock** (in the sidebar)
2. Enable AutoLock
3. Set the number of days of inactivity before auto-locking
4. Save

系统随后每小时自动巡检一次，锁定符合条件的讨论。
The system then checks every hour and locks eligible discussions automatically.

## 设置项 · Settings

| 设置项 Setting | 默认值 Default | 说明 Description |
|---------|---------|-------------|
| Enabled 启用 | off 关 | 自动锁定总开关 · master switch for auto-locking |
| Days 天数 | 30 | 不活跃多少天后锁定 · days of inactivity before locking |
| Ignore Sticky 忽略置顶 | on 开 | 不锁定置顶讨论 · don't lock pinned discussions |
| Ignore Locked 忽略已锁定 | on 开 | 跳过已锁定的讨论 · skip already-locked discussions |

## License · 许可证

**AGPL-3.0-or-later** — 可自由使用、修改、商用；但若你修改后对外提供服务，必须以相同许可开源你的改动。完整条款见 [LICENSE](LICENSE)。

**AGPL-3.0-or-later** — free to use, modify and commercialize; however, if you modify it and offer it to others as a service, your changes must be released under the same license. See [LICENSE](LICENSE) for the full terms.

---

## Contact / 联系作者

| 渠道 Channel | 地址 Address |
|---|---|
| 🏝️ Forum (CatIsland) | https://bbs.cathi.cn |
| 💬 QQ Group | 369748859 |
| 📮 Email | 792818521@qq.com |
