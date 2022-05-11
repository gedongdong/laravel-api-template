import PropTypes from '../_util/vue-types';
import classNames from '../_util/classNames';
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'Pager',
  inheritAttrs: false,
  props: {
    rootPrefixCls: String,
    page: Number,
    active: { type: Boolean, default: undefined },
    last: { type: Boolean, default: undefined },
    locale: PropTypes.object,
    showTitle: { type: Boolean, default: undefined },
    itemRender: {
      type: Function,
      default: () => {},
    },
    onClick: {
      type: Function,
    },
    onKeypress: {
      type: Function,
    },
  },
  eimt: ['click', 'keypress'],
  setup(props, { emit, attrs }) {
    const handleClick = () => {
      emit('click', props.page);
    };
    const handleKeyPress = (event: KeyboardEvent) => {
      emit('keypress', event, handleClick, props.page);
    };
    return () => {
      const { showTitle, page, itemRender } = props;
      const { class: _cls, style } = attrs;
      const prefixCls = `${props.rootPrefixCls}-item`;
      const cls = classNames(
        prefixCls,
        `${prefixCls}-${props.page}`,
        {
          [`${prefixCls}-active`]: props.active,
          [`${prefixCls}-disabled`]: !props.page,
        },
        _cls,
      );

      return (
        <li
          onClick={handleClick}
          onKeypress={handleKeyPress}
          title={showTitle ? String(page) : null}
          tabindex="0"
          class={cls}
          style={style}
        >
          {itemRender({
            page,
            type: 'page',
            originalElement: <a rel="nofollow">{page}</a>,
          })}
        </li>
      );
    };
  },
});
