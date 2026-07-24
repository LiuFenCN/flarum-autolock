import Component from 'flarum/common/Component';
import Button from 'flarum/common/components/Button';
import Switch from 'flarum/common/components/Switch';
import FieldSet from 'flarum/common/components/FieldSet';
import InputText from 'flarum/common/components/InputText';
import SaveButton from 'flarum/common/components/SaveButton';
import Alert from 'flarum/common/components/Alert';
import app from 'flarum/forum/app';

interface IAttrs {
  [key: string]: unknown;
}

export default class AutoLockSettingsPage extends Component<IAttrs> {
  loading = false;
  success = false;

  enabled: boolean = false;
  days: number = 90;
  ignoreSticky: boolean = true;
  ignoreLocked: boolean = true;

  oninit(vnode: unknown): void {
    super.oninit(vnode);
    const forum = app.data.attributes; // or app.forum.attribute()
    this.enabled = forum['acolasiAutolock.enabled'] || false;
    this.days = forum['acolasiAutolock.days'] || 90;
    this.ignoreSticky = forum['acolasiAutolock.ignoreSticky'] !== false;
    this.ignoreLocked = forum['acolasiAutolock.ignoreLocked'] !== false;
  }

  content(): Array<unknown> {
    return [
      <div className="AutoLockSettings">
        <h2>{app.translator.trans('acolasi-autolock.admin.page.title')}</h2>
        <p>{app.translator.trans('acolasi-autolock.admin.page.description')}</p>

        {this.success && (
          <div className="Alert Alert--success" dismissible={false}>
            {app.translator.trans('acolasi-autolock.admin.saved')}
          </div>
        )}

        <form onsubmit={this.save.bind(this)}>
          <FieldSet label={app.translator.trans('acolasi-autolock.admin.settings')}>
            <Switch
              state={this.enabled}
              onchange={(val: boolean) => (this.enabled = val)}
              label={app.translator.trans('acolasi-autolock.admin.enabled_label')}
              description={app.translator.trans('acolasi-autolock.admin.enabled_help')}
            />

            {this.enabled && (
              <>
                <InputText
                  type="number"
                  min={1}
                  max={365}
                  value={this.days.toString()}
                  onchange={(val: string) => (this.days = parseInt(val) || 90)}
                  label={app.translator.trans('acolasi-autolock.admin.days_label')}
                  description={app.translator.trans('acolasi-autolock.admin.days_help')}
                />

                <Switch
                  state={this.ignoreSticky}
                  onchange={(val: boolean) => (this.ignoreSticky = val)}
                  label={app.translator.trans('acolasi-autolock.admin.ignore_sticky_label')}
                  description={app.translator.trans('acolasi-autolock.admin.ignore_sticky_help')}
                />

                <Switch
                  state={this.ignoreLocked}
                  onchange={(val: boolean) => (this.ignoreLocked = val)}
                  label={app.translator.trans('acolasi-autolock.admin.ignore_locked_label')}
                  description={app.translator.trans('acolasi-autolock.admin.ignore_locked_help')}
                />
              </>
            )}
          </FieldSet>

          <SaveButton loading={this.loading} />
        </form>
      </div>
    ];
  }

  save(e: Event): void {
    e.preventDefault();
    this.loading = true;
    this.success = false;

    app.request({
      method: 'PATCH',
      url: app.forum.attribute('apiUrl'),
      body: {
        data: {
          type: 'forums',
          id: '1',
          attributes: {
            'acolasiAutolock.enabled': this.enabled,
            'acolasiAutolock.days': this.days,
            'acolasiAutolock.ignoreSticky': this.ignoreSticky,
            'acolasiAutolock.ignoreLocked': this.ignoreLocked,
          },
        },
      },
    })
      .then(() => {
        this.loading = false;
        this.success = true;
        m.redraw();
      })
      .catch((err: Error) => {
        this.loading = false;
        alert(err.message);
        m.redraw();
      });
  }
}
