using System;
using Application.Shared;
using Microsoft.Extensions.Configuration;

namespace Rewards.API.ApplicationConfigurationValidators.Validators
{
    internal class DeploymentSettingsValidator : IConfigurationValidator
    {
        void IConfigurationValidator.ValidateOrThrow(IConfiguration configuration)
        {
            var deploymentSection = configuration.GetSection(ConfigurationNames.DEPLOYMENT_CONFIGURATION);
            var deploymentInfo = deploymentSection.Get<DeploymentConfiguration>();

            if (deploymentInfo == null || deploymentInfo.WebClientBaseAddress == null || deploymentInfo.ServerAddress == null)
                throw new Exception($"Application cannot start: Deployment Configuration not set.");
        }
    }
}
