using Application.Shared;
using Microsoft.Extensions.Configuration;
using Microsoft.Extensions.DependencyInjection;
using Rewards.API.ApplicationConfigurationValidators;

namespace Rewards.API.ApplicationServices.ServiceExtensions
{
    internal static class DeploymentConfigurationExtension
    {
        public static IServiceCollection AddDeploymentAddressConfiguration(this IServiceCollection services, IConfiguration configuration)
        {
            var deploymentSection = configuration.GetSection(ConfigurationNames.DEPLOYMENT_CONFIGURATION);
            services.Configure<DeploymentConfiguration>(deploymentSection);
            return services;
        }
    }
}
