<!-- Postback Tab -->
<div x-show="activeTab === 'postback'" x-cloak>
    <div class="space-y-4">
        <!-- Postback URL Info Card -->
        <div class="card p-4 bg-blue-50 border-blue-200">
            <div class="flex items-start gap-3">
                <svg class="h-5 w-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-bold text-blue-900 tracking-tight">Postback URL Configuration</h3>
                    <p class="text-xs text-blue-700 mt-1 leading-relaxed">
                        Configure this URL in your iMonetizeIt account to receive conversion notifications
                    </p>
                    <div class="mt-3 flex items-center gap-2">
                        <code class="text-xs bg-white px-3 py-1.5 rounded border border-blue-300 flex-1 font-mono leading-relaxed">
                            <?php echo ($_SERVER['REQUEST_SCHEME'] ?? 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost'); ?>/postback.php?payout={payout}&country={country}&traffic_type={traffic_type}
                        </code>
                        <button @click="copyPostbackUrl()" class="btn-primary text-xs font-semibold py-1.5 px-3 whitespace-nowrap">
                            <svg class="h-3.5 w-3.5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            Copy
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <!-- Total Conversions -->
            <div class="card p-3">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-muted-foreground font-semibold tracking-wide uppercase">Total Conversions</p>
                        <p class="text-2xl font-bold mt-1.5 tabular-nums" x-text="postbackStats.total_conversions"></p>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Payout -->
            <div class="card p-3">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-muted-foreground font-semibold tracking-wide uppercase">Total Payout</p>
                        <p class="text-2xl font-bold mt-1.5 font-mono tabular-nums text-green-600" x-text="'$' + postbackStats.total_payout.toFixed(2)"></p>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                        <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Today's Conversions -->
            <div class="card p-3">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-muted-foreground font-semibold tracking-wide uppercase">Today</p>
                        <p class="text-2xl font-bold mt-1.5 tabular-nums" x-text="postbackStats.today_conversions"></p>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                        <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Average Payout -->
            <div class="card p-3">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-muted-foreground font-semibold tracking-wide uppercase">Avg Payout</p>
                        <p class="text-2xl font-bold mt-1.5 font-mono tabular-nums text-orange-600" x-text="'$' + postbackStats.avg_payout.toFixed(2)"></p>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center">
                        <svg class="h-5 w-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters and Actions -->
        <div class="card p-3">
            <div class="flex flex-wrap items-center gap-2 justify-between">
                <div class="flex items-center gap-2 flex-1">
                    <input type="date"
                           x-model="postbackFilters.start_date"
                           class="input text-xs font-medium w-auto"
                           @change="loadPostbacks()">
                    <span class="text-xs text-muted-foreground font-medium">to</span>
                    <input type="date"
                           x-model="postbackFilters.end_date"
                           class="input text-xs font-medium w-auto"
                           @change="loadPostbacks()">
                    <button @click="loadPostbacks()"
                            class="btn-primary text-xs font-semibold py-1.5 px-3"
                            :disabled="postbackFilters.loading">
                        <svg class="h-3.5 w-3.5 inline-block mr-1" :class="{'animate-spin': postbackFilters.loading}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Refresh
                    </button>
                </div>
                <div class="text-xs text-muted-foreground font-medium">
                    Total: <span x-text="postbackData.length" class="font-bold text-foreground tabular-nums"></span> records
                </div>
            </div>
        </div>

        <!-- Tables Grid - Side by Side -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <!-- Postback Data Table -->
            <div class="card p-0 overflow-hidden">
                <div class="p-3 border-b bg-muted">
                    <h4 class="text-sm font-bold tracking-tight">CPA Conversions</h4>
                </div>
                <div class="overflow-x-auto max-h-[500px] overflow-y-auto">
                    <table class="w-full text-sm">
                    <thead class="bg-muted sticky top-0 z-10">
                        <tr>
                            <th class="h-10 px-4 text-left align-middle font-bold text-foreground tracking-wide">#</th>
                            <th class="h-10 px-4 text-right align-middle font-bold text-foreground tracking-wide">Payout</th>
                            <th class="h-10 px-4 text-center align-middle font-bold text-foreground tracking-wide">Country</th>
                            <th class="h-10 px-4 text-left align-middle font-bold text-foreground tracking-wide">Traffic Type</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <template x-if="postbackFilters.loading">
                            <tr>
                                <td colspan="4" class="py-8 text-center text-muted-foreground font-semibold">
                                    <svg class="animate-spin h-5 w-5 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Loading conversions...
                                </td>
                            </tr>
                        </template>
                        <template x-if="!postbackFilters.loading && postbackData.length === 0">
                            <tr>
                                <td colspan="4" class="py-8 text-center text-muted-foreground font-semibold">
                                    <svg class="h-12 w-12 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    No conversions found
                                </td>
                            </tr>
                        </template>
                        <template x-for="(item, index) in postbackData" :key="item.id">
                            <tr class="hover:bg-muted/50 transition-all duration-200">
                                <td class="px-4 py-3 align-middle text-muted-foreground font-bold tabular-nums" x-text="index + 1"></td>
                                <td class="px-4 py-3 align-middle text-right">
                                    <span class="font-black text-green-600 font-mono tabular-nums" x-text="'$' + parseFloat(item.payout).toFixed(2)"></span>
                                </td>
                                <td class="px-4 py-3 align-middle text-center">
                                    <span class="inline-flex items-center justify-center gap-2 font-bold">
                                        <span class="text-xl" x-text="getCountryFlag(item.country)"></span>
                                        <span x-text="item.country"></span>
                                    </span>
                                </td>
                                <td class="px-4 py-3 align-middle">
                                    <span class="font-bold" x-text="item.traffic_type || '-'"></span>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                </div>
            </div>

            <!-- Real-time Traffic Monitoring -->
            <div class="card p-0 overflow-hidden">
                <div class="flex items-center justify-between p-3 border-b bg-muted">
                    <h4 class="text-sm font-bold tracking-tight">Real-time Traffic Logs</h4>
                    <button @click="clearLogs"
                            class="btn btn-default text-xs font-semibold py-1 px-2"
                            :disabled="isClearingLogs">
                        <svg x-show="!isClearingLogs"
                             class="h-3.5 w-3.5"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        <svg x-show="isClearingLogs"
                             class="h-3.5 w-3.5 animate-spin"
                             fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75"
                                  d="M4 12a8 8 0 0 1 8-8"
                                  stroke="currentColor" stroke-width="4" stroke-linecap="round"></path>
                        </svg>
                    </button>
                </div>

                <div class="relative overflow-x-auto overflow-y-auto max-h-[500px] scroll-logs">
                <table class="w-full text-sm">
                    <thead class="bg-muted sticky top-0 z-10">
                    <tr>
                        <th class="h-10 px-4 text-left align-middle font-bold text-foreground tracking-wide">
                            IP Address
                        </th>
                        <th class="h-10 px-4 text-left align-middle font-bold text-foreground tracking-wide">
                            Country
                        </th>
                        <th class="h-10 px-4 text-left align-middle font-bold text-foreground tracking-wide">
                            Decision
                        </th>
                        <th class="h-10 px-4 text-left align-middle font-bold text-foreground tracking-wide hidden sm:table-cell">
                            UA
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y">
                    <template x-if="logs.length === 0">
                        <tr>
                            <td colspan="4" class="p-3 text-center text-xs text-muted-foreground font-semibold">
                                No traffic logs yet.
                            </td>
                        </tr>
                    </template>
                    <template x-for="r in logs" :key="r.id">
                        <tr class="transition-all duration-200 hover:bg-muted/50">
                            <td class="px-4 py-3 align-middle">
                                <code
                                    class="relative rounded bg-muted px-2 py-1 font-mono font-semibold text-foreground/80"
                                    x-text="r.ip"></code>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <span class="font-bold" x-text="r.country_code || 'XX'"></span>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <span class="font-bold"
                                      x-text="r.decision === 'A' ? 'Redirect' : 'Fallback'"></span>
                            </td>
                            <td class="px-4 py-3 align-middle hidden sm:table-cell">
                                <span
                                    class="text-muted-foreground font-semibold max-w-xs truncate block"
                                    x-text="r.ua"></span>
                            </td>
                        </tr>
                    </template>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
