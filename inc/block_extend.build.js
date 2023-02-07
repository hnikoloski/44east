wp.blocks.registerBlockType('core/spacer', {
    title: 'Spacer Block with Mobile Space',
    icon: 'minus',
    category: 'common',
    attributes: {
        height: {
            type: 'number',
            default: 50
        },
        mobileSpace: {
            type: 'number',
            default: 25
        }
    },
    edit: function (props) {
        return wp.element.createElement(
            'div',
            { className: 'spacer-block-container' },
            wp.element.createElement(
                'label',
                {},
                'Spacer Height:',
                wp.element.createElement('input', {
                    type: 'number',
                    value: props.attributes.height,
                    onChange: function (event) {
                        props.setAttributes({ height: event.target.value });
                    }
                })
            ),
            wp.element.createElement(
                'label',
                {},
                'Mobile Spacer Height:',
                wp.element.createElement('input', {
                    type: 'number',
                    value: props.attributes.mobileSpace,
                    onChange: function (event) {
                        props.setAttributes({ mobileSpace: event.target.value });
                    }
                })
            )
        );
    },
    save: function (props) {
        return wp.element.createElement(
            'div',
            { className: 'mobile-spacer', style: { height: props.attributes.mobileSpace + 'px' } }
        );
    }
});