using System;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Authentication.Cookies;
using Microsoft.AspNetCore.Authorization;
using Microsoft.Extensions.DependencyInjection;
using Rewards.API.ApplicationServices.Authorization.BaseOnAccountType;

namespace Rewards.API.ApplicationServices.ServiceExtensions
{
    internal static class SecurityConfigurationExtension
    {
        internal static IServiceCollection AddSecurityConfiguration(this IServiceCollection services)
        {
            services.AddAuthorization(opt => opt.AddPolicy(AccountTypeRequirement.ACCOUNT_TYPE_POLICY, policyBuilder => policyBuilder.Requirements.Add(new HasAccountTypeRequirement())));
            services.AddScoped<IAuthorizationHandler, AccountTypeBasedAuthorisationHandler>();
            services.AddCokieAuthentication();
            return services;
        }
        private static IServiceCollection AddCokieAuthentication(this IServiceCollection services)
        {
            services.AddAuthentication(CookieAuthenticationDefaults.AuthenticationScheme)
            .AddCookie(CookieAuthenticationDefaults.AuthenticationScheme, options =>
            {
                options.Cookie.Name = CookieAuthenticationDefaults.AuthenticationScheme;
                options.Cookie.SameSite = Microsoft.AspNetCore.Http.SameSiteMode.None;
                options.SlidingExpiration = true;
                options.ExpireTimeSpan = TimeSpan.FromDays(1);
                options.Events = new CookieAuthenticationEvents
                {
                    OnRedirectToLogin = redirectContext =>
                    {
                        redirectContext.HttpContext.Response.StatusCode = 401;
                        return Task.CompletedTask;
                    }
                };
            });
            return services;
        }
    }
}
