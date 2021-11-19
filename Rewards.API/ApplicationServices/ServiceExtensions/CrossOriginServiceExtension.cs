using Application.Shared;
using Microsoft.Extensions.Configuration;
using Microsoft.Extensions.DependencyInjection;
using Rewards.API.ApplicationConfigurationValidators;

namespace Rewards.API.ApplicationServices.ServiceExtensions
{
    internal static class CrossOriginServiceExtension
    {
        internal static IServiceCollection AddCrossOriginRequestRules(this IServiceCollection services, IConfiguration configuration)
        {
            var deploymentSection = configuration.GetSection(ConfigurationNames.DEPLOYMENT_CONFIGURATION);
            var clientApp = deploymentSection.Get<DeploymentConfiguration>().WebClientBaseAddress;
            services.AddCors(options =>
                             options.AddPolicy(ConfigurationNames.CROSS_ORIGIN_POLICY,
                             builder => builder.WithOrigins(clientApp, "http://localhost:8080", "https://azany-draft.netlify.app")
                                       .AllowAnyMethod()
                                       .AllowAnyHeader()
                                       .AllowCredentials()));
            return services;
        }
    }
}
