<template>
    <v-container>
        <v-row align="center" justify="center">
            <v-hover v-slot="{ isHovering, props }">
                <v-card
                    :variant="isHovering ? 'tonal' : 'elevated'"
                    class="mx-auto rounded-lg"
                    width="100%"
                    v-bind="props"
                    :color="isHovering ? 'primary' : undefined"
                >
                    <v-card-item>
                        <div class="d-flex align-center ma-3">
                            <div class="img">
                                <v-avatar size="large" color="primary">
                                    <span class="text-subtitle-2"> QQ </span>
                                </v-avatar>
                            </div>

                            <div class="text ml-3 w-100">
                                <div class="text-overline">
                                    nama group (if available else general)
                                </div>
                                <div class="text-h6 mb-1">Judul Topic</div>
                                <div class="text-subtitle">Pertanyaan</div>
                            </div>
                            <div class="w-100 keterangan d-flex flex-column align-end">
                                <div class="chip-wrapper mb-4">
                                    <v-chip
                                        class="ma-2 w-auto"
                                        color="primary"
                                        label>
                                        Category
                                    </v-chip>
                                </div>
                                <div class="sub-keterangan d-flex">
                                    <div class="d-flex mr-4">
                                        <v-icon size="small" class="mr-2" icon="mdi-message"></v-icon>
                                        <span class="text-caption">10</span>
                                    </div>
                                    <span class="text-caption"
                                        >Last Update : 13 Januari 2024 08:00</span
                                    >
                                </div>
                            </div>
                        </div>
                    </v-card-item>
                </v-card>
            </v-hover>
        </v-row>
    </v-container>
</template>
<script></script>
