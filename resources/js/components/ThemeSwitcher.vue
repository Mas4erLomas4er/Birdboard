<template>
    <div class="mr-6 flex items-center">
        <button
            v-for="(color, theme) in themes"
            class="rounded-full w-5 h-5 bg-page border border-2 mr-2 outline-none"
            :style="{backgroundColor: color}"
            :class="{'border-accent' : selectedTheme === theme}"
            @click="selectedTheme = theme"
        ></button>
    </div>
</template>

<script>
export default {
    name : "ThemeSwitcher",
    data () {
        return {
            themes : {
                'theme-light' : '#f5f6f9',
                'theme-dark' : '#1F2027',
            },
            selectedTheme : 'theme-light',
        };
    },

    created () {
        this.selectedTheme = localStorage.getItem( 'theme' ) || 'theme-light';
    },

    watch : {
        selectedTheme ( $newTheme, $oldTheme ) {
            document.body.classList.replace( $oldTheme, $newTheme );
            localStorage.setItem( 'theme', this.selectedTheme );
        },
    },
}
</script>
