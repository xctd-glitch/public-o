<!-- Overview Tab -->
<div x-show="activeTab === 'overview'" x-cloak>
    <div class="space-y-4">
        <!-- Statistics Cards -->
        <div class="grid gap-3 grid-cols-2 md:grid-cols-4">
            <!-- Total Requests -->
            <div class="card p-3 text-center">
                <div class="inline-flex items-center justify-center gap-1.5 mb-1.5">
                    <img src="/assets/icons/fox-head.svg" alt="Fox head logo" class="h-3.5 w-3.5" width="14" height="14">
                    <h3 class="text-[11px] font-medium text-muted-foreground uppercase tracking-wide">Total</h3>
                </div>
                <div class="text-xl font-semibold leading-tight" x-text="logs.length"></div>
                <p class="text-[10px] text-muted-foreground mt-0.5">Last 50 records</p>
            </div>

            <!-- Redirected A -->
            <div class="card p-3 text-center">
                <div class="inline-flex items-center justify-center gap-1.5 mb-1.5">
                    <svg class="h-3.5 w-3.5 text-emerald-500/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"></path>
                    </svg>
                    <h3 class="text-[11px] font-medium text-muted-foreground uppercase tracking-wide">Redirect A</h3>
                </div>
                <div class="text-xl font-semibold leading-tight"
                     x-text="logs.filter(l => l.decision === 'A').length"></div>
                <p class="text-[10px] text-muted-foreground mt-0.5">Decision A</p>
            </div>

            <!-- Fallback B -->
            <div class="card p-3 text-center">
                <div class="inline-flex items-center justify-center gap-1.5 mb-1.5">
                    <svg class="h-3.5 w-3.5 text-amber-500/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"></path>
                    </svg>
                    <h3 class="text-[11px] font-medium text-muted-foreground uppercase tracking-wide">Fallback B</h3>
                </div>
                <div class="text-xl font-semibold leading-tight"
                     x-text="logs.filter(l => l.decision === 'B').length"></div>
                <p class="text-[10px] text-muted-foreground mt-0.5">Desktop / Bot / VPN</p>
            </div>

            <!-- System summary -->
            <div class="card p-3 text-center">
                <div class="inline-flex items-center justify-center gap-1.5 mb-1.5">
                    <span class="inline-flex h-2 w-2 rounded-full"
                          :class="cfg.system_on ? (muteStatus.isMuted ? 'bg-amber-500' : 'bg-emerald-500') : 'bg-black'"></span>
                    <h3 class="text-[11px] font-medium text-muted-foreground uppercase tracking-wide">System</h3>
                </div>
                <div class="text-xl font-semibold leading-tight"
                     x-text="cfg.system_on ? (muteStatus.isMuted ? 'MUTED' : 'ACTIVE') : 'OFF'"></div>
                <p class="text-[10px] text-muted-foreground mt-0.5"
                   x-text="cfg.system_on ? muteStatus.timeRemaining : 'System disabled'"></p>
            </div>
        </div>

        <!-- Smartlinks Statistics Cards -->
        <div class="grid gap-3 grid-cols-1 md:grid-cols-3">
            <!-- Total Conversions -->
            <div class="card p-4 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-muted-foreground font-bold tracking-wide uppercase">Today Conversions</p>
                        <p class="text-3xl font-black mt-1.5 tabular-nums" x-text="postbackStats.today_conversions"></p>
                    </div>
                    <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Payout -->
            <div class="card p-4 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-muted-foreground font-bold tracking-wide uppercase">Today Payout</p>
                        <p class="text-3xl font-black mt-1.5 font-mono tabular-nums text-green-600" x-text="'$' + (postbackStats.today_payout || 0).toFixed(2)"></p>
                    </div>
                    <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Clicks -->
            <div class="card p-4 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-muted-foreground font-bold tracking-wide uppercase">Today Clicks</p>
                        <p class="text-3xl font-black mt-1.5 tabular-nums" x-text="getTodayClicksCount()"></p>
                    </div>
                    <div class="h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center">
                        <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mini Chart -->
        <div class="card p-4 transition-all duration-300 hover:shadow-md">
            <h3 class="text-sm font-bold mb-4 tracking-tight">Conversions Chart (Last 7 Days)</h3>
            <div class="h-48 flex items-end justify-between gap-2">
                <template x-for="(day, index) in postbackChartData" :key="index">
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <div class="w-full bg-gradient-to-t from-green-500 to-green-400 rounded-t hover:from-green-600 hover:to-green-500 transition-all duration-300 relative group cursor-pointer"
                             :style="'height: ' + getChartHeight(day.conversions) + '%; min-height: 4px;'">
                            <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-black text-white text-[10px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-all duration-200 whitespace-nowrap z-10">
                                <div class="font-bold" x-text="day.conversions + ' conversions'"></div>
                                <div x-text="'$' + parseFloat(day.payout).toFixed(2)"></div>
                            </div>
                        </div>
                        <span class="text-[10px] text-muted-foreground font-semibold" x-text="formatChartDate(day.date)"></span>
                    </div>
                </template>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card p-4">
            <h3 class="text-sm font-semibold mb-3">Quick Actions</h3>
            <div class="grid gap-2 grid-cols-1 md:grid-cols-3">
                <button
                    type="button"
                    @click="activeTab = 'routing'"
                    class="btn text-left justify-start">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Configure Routing
                </button>

                <button
                    type="button"
                    @click="activeTab = 'env-config'"
                    class="btn text-left justify-start">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                    </svg>
                    Environment Settings
                </button>

                <button
                    type="button"
                    @click="activeTab = 'postback'"
                    class="btn text-left justify-start">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Smartlinks Statistics
                </button>
            </div>
        </div>

        <!-- System Status -->
        <div class="card p-4">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-semibold">System Status</h3>
                <button
                    type="button"
                    @click="cfg.system_on = !cfg.system_on; save()"
                    class="btn btn-sm"
                    :class="cfg.system_on ? 'btn-primary' : 'btn-outline'"
                    :disabled="isSavingCfg"
                    data-sniper="1">
                    <svg x-show="isSavingCfg" class="h-3 w-3 mr-1 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" d="M4 12a8 8 0 0 1 8-8" stroke="currentColor" stroke-width="4" stroke-linecap="round"></path>
                    </svg>
                    <span x-text="isSavingCfg ? 'Saving...' : (cfg.system_on ? 'Turn Off' : 'Turn On')"></span>
                </button>
            </div>

            <div class="space-y-2 text-xs">
                <div class="flex justify-between py-2 border-b">
                    <span class="text-muted-foreground">Status</span>
                    <span class="font-medium"
                          :class="cfg.system_on ? (muteStatus.isMuted ? 'text-amber-600' : 'text-emerald-600') : 'text-muted-foreground'"
                          x-text="cfg.system_on ? (muteStatus.isMuted ? 'Muted' : 'Active') : 'Offline'"></span>
                </div>
                <div class="flex justify-between py-2 border-b" x-show="cfg.system_on">
                    <span class="text-muted-foreground">Redirect URL</span>
                    <span class="font-medium truncate ml-2 max-w-xs" x-text="cfg.redirect_url || 'Not set'"></span>
                </div>
                <div class="flex justify-between py-2 border-b">
                    <span class="text-muted-foreground">Total Logs</span>
                    <span class="font-medium" x-text="logs.length + ' / 50'"></span>
                </div>
                <div class="flex justify-between py-2" x-show="cfg.system_on">
                    <span class="text-muted-foreground">Cycle Status</span>
                    <span class="font-medium" x-text="muteStatus.timeRemaining"></span>
                </div>
            </div>
        </div>
    </div>
</div>
