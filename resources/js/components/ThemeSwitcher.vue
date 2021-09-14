<template>
    <button class="" @click="switchTheme">Switch Theme</button>
    <!--    <div class="mr-6 flex items-center">-->
    <!--        <button-->
    <!--            v-for="(color, theme) in themes"-->
    <!--            class="rounded-full w-5 h-5 bg-page border border-2 mr-2 outline-none"-->
    <!--            :style="{backgroundColor: color}"-->
    <!--            :class="{'border-accent' : selectedTheme === theme}"-->
    <!--            @click="selectedTheme = theme"-->
    <!--        ></button>-->
    <!--    </div>-->
</template>

<script>
export default {
    name : "ThemeSwitcher",
    data () {
        return {
            themes : [
                { name : 'theme-light', color : '#f5f6f9' },
                { name : 'theme-dark', color : '#1F2027' },
            ],
            selectedTheme : 'theme-light',
            selectedThemeId : 0,
        };
    },

    created () {
        this.selectedTheme = localStorage.getItem( 'theme' ) || 'theme-light';
        this.selectedThemeId = parseInt( localStorage.getItem( 'theme-id' ) || 0 );
    },

    watch : {
        selectedTheme ( $newTheme, $oldTheme ) {
            document.body.classList.replace( $oldTheme, $newTheme );
            localStorage.setItem( 'theme', this.selectedTheme );
            localStorage.setItem( 'theme-id', this.selectedThemeId );
        },
    },

    methods : {
        switchTheme () {
            this.selectedThemeId = ( this.selectedThemeId + 1 ) % this.themes.length;
            this.selectedTheme = this.themes[ this.selectedThemeId ].name;
        },
    },
}
</script>
