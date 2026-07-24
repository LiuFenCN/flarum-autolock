import { extend } from 'flarum/common/extend';
import app from 'flarum/forum/app';
import AdminNav from 'flarum/admin/components/AdminNav';
import LinkButton from 'flarum/common/components/LinkButton';
import SettingsPage from './components/AutoLockSettingsPage';

app.initializers.add('acolasi/autolock', () => {
  // Add nav item
  extend(AdminNav.prototype, 'items', (items) => {
    items.add(
      'autolock',
      <LinkButton href={app.route('acolasi-autolock-settings')} icon="fas fa-lock">
        {app.translator.trans('acolasi-autolock.admin.nav.title')}
      </LinkButton>,
      80
    );
  });

  // Add settings page route
  app.routes['acolasi-autolock-settings'] = { path: '/autolock', component: SettingsPage };
});
