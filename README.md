# TMS (Tampere Multisite) WordPress Plugin Boilerplate

## Installation

The boilerplate plugin works as a WordPress plugin straight out of the box. To customize the plugin for your needs, you need to replace all texts related to the boilerplate and write proper descriptions into various files.

### Replacements

To customize the plugin, do the following replacements:

- **tms-plugin-boilerplate** - Replace with a suitable name for the plugin directory name. This is also used as the package name in package.json.
- **Boilerplate** - Replace with a suitable name for the plugin namespace, and the plugin class prefix. You must also refactor the plugin class filename for the autoloader to work.
- **boilerplate()** - Replace with a global function name. This function returns the plugin singleton.
- **{{plugin-name}}** - Replace with a proper plugin name to be displayed for your admin users.
- **{{plugin-description}}** - Replace with a text describing your plugin.
- **{{text-domain}}** - Replace with a text domain identifier.

Some texts are also related to [Geniem](https://www.geniem.com). Search and replace Geniem related texts if necessary.

## Contributing

Contributions are highly welcome! Just leave a pull request of your awesome well-written must-have feature.
