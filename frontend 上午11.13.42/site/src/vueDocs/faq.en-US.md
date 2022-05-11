# FAQ

Here are the frequently asked questions about Ant Design Vue that you should look up before you ask in community or create new issue.

### Are you going to provide Sass/Stylus(etc...) style file?

No, actually, you can convert Less to Sass/Stylus(etc...) with tools (which you can Google).

### How to use DatePicker with dayjs

We also provide another implementation, which we provide with antd-dayjs-webpack-plugin, replacing dayjs with Day.js directly without changing a line of existing code. More info can be found at [antd-dayjs-webpack-plugin](https://github.com/ant-design/antd-dayjs-webpack-plugin).

### Internationalization does not take effect?

The language pack provided by the component does not affect date formatting. You need to import the dayjs language pack and apply it. Refer to the `ConfigProvider` component.

### `Select Dropdown DatePicker TimePicker Popover Popconfirm` disappear when I click another popup component inside it, How to resolve it?

Use `<a-select :getPopupContainer="trigger => trigger.parentNode">` to render component inside Popover. (Or other getXxxxContainer props)

### `Select Dropdown DatePicker TimePicker Popover Popconfirm` scroll with the page?

Use `<a-select :getPopupContainer="trigger => trigger.parentNode">` to render component inside the scroll area. (Or other getXxxxContainer props).

### How to modify the default theme of Ant Design Vue?

See [Customize Theme](/docs/vue/customize-theme/).

### It doesn't work when I change `defaultValue`,`defaultOpenKeys`, `initialValue` dynamically.

The `defaultXxxx` (like `defaultValue`) of `Input`/`Select`(etc...) only works in first render. This feature is referenced from [React](https://facebook.github.io/react/docs/forms.html#controlled-components).

### I set the `value` of `Input`/`Select`(etc...), and then, it cannot be changed by user's action.

Try `defaultValue` or `change` or `v-model` to change `value`.

### ant-design-vue override my global styles!

Yes, ant-design-vue is designed to develop a complete background application, we override some global styles for styling convenience, and it can't be removed now. More info trace https://github.com/ant-design/ant-design/issues/4331 .

Or, follow the instructions in [How to avoid modifying global styles?](docs/react/customize-theme#How-to-avoid-modifying-global-styles-?)

### `ant-design-vue` makes only poor user experience on mobile.

`ant-design-vue` is not designed for mobile.

### When I set `mode` to DatePicker/RangePicker, I cannot select year or month anymore?

In a real world development, you may need a YearPicker, MonthRangePicker or WeekRangePicker. You are trying to add `mode` to DatePicker/RangePicker expected to implement those pickers. However, the DatePicker/RangePicker cannot be selected and the panels won't close now.

That is because `<DatePicker mode="year" />` do not equal to `YearPicker`, `<RangePicker mode="month" />` do not equal to `MonthRangePicker` either. The `mode` property was added to support [showing time picker panel in DatePicker](https://github.com/ant-design/ant-design/issues/5190), which simply control the displayed panel and won't change the original date picking behavior of `DatePicker/RangePicker` (for instance you still need to click date cell to finish selection in a DatePicker, whatever the `mode` is).

##### Solution

The following articles are the implementation articles of the react version, the ideas are the same. In [one article](https://juejin.im/post/5cf65c366fb9a07eca6968f9) or [another article](https://www.cnblogs.com/zyl-Tara/p/10197177.html) approach, using methods `mode` and `panelChange` to encapsulate a component such as `YearPicker`. We plan to add more date related components directly in ant-design-vue@2.0 to support these needs.
