<template>
    <div class="dropdown">
        <div class="" @click="opened = !opened" aria-haspopup="true" :aria-expanded="opened">
            <slot name="trigger"></slot>
        </div>

        <div v-show="opened" :style="{width: width}"
             class="dropdown-menu"
             :class="align === 'left' ? 'left-0' : 'right-0'"
        >
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    name : "Dropdown",

    props : {
        align : {
            type : String,
            default : 'left',
        },
        width : {
            type : String,
            default : '150px',
        },
    },

    data () {
        return {
            opened : false,
        }
    },

    watch : {
        opened ( value ) {
            if ( value ) {
                document.addEventListener( 'click', this.closeDropdown );
            }
        },
    },

    methods : {
        closeDropdown ( event ) {
            if ( event.target.closest( '.dropdown' ) ) return;

            this.opened = false;

            document.removeEventListener( 'click', this.closeDropdown );
        },
    },
}
</script>

<style scoped>

</style>
