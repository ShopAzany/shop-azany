using Microsoft.AspNetCore.Builder;
using Microsoft.AspNetCore.Http;

namespace Rewards.API.ApplicationServices.ServiceExtensions
{
    internal static class CookiesExtension
    {
        internal static IApplicationBuilder UseCookies(this IApplicationBuilder application)
        {
            var cookiesPolicyOptions = new CookiePolicyOptions
            {
                MinimumSameSitePolicy = SameSiteMode.Lax
            };
            application.UseCookiePolicy(cookiesPolicyOptions);
            return application;
        }
    }
}
